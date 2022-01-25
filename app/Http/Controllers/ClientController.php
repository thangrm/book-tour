<?php

namespace App\Http\Controllers;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\Type;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Exception;

class ClientController extends Controller
{
    protected $notification;
    protected $clientService;

    public function __construct(Notification $notification, ClientService $clientService)
    {
        $this->notification = $notification;
        $this->clientService = $clientService;
    }

    /**
     * Display a Homepage.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Destination $destination, Type $type, Tour $tour)
    {
        $destinations = $destination->getByStatus(1, 8);
        $types = $type->getByStatus(1, 8);
        $trendingTours = $tour->getByTrending(true, 8);
        $tours = $tour->getByTrending(false, 8);

        return view('index', compact(['destinations', 'trendingTours', 'types', 'tours']));
    }

    /**
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function listTour(Request $request, $slug, Type $type)
    {
        $types = $type->getOrderByTitle();
        $tours = $this->clientService->getListTour($request, $slug);

        return view('list_tour', compact(['tours', 'types']));
    }

    /**
     * Show tour detail.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour(Request $request, $slug, Tour $tourModel)
    {
        $tour = $tourModel->getTourBySlug($slug);
        $tour->faqs = $tour->faqs(true)->get();
        $tour->reviews = $tour->reviews(true)->get();
        $relateTours = $tourModel->getRelated($tour->destination_id);
        $reviews = $tour->reviews(true)->paginate(8);
        $rateReview = Utilities::calculatorRateReView($tour->reviews);

        return view('tour_detail', compact(['tour', 'relateTours', 'reviews', 'rateReview']));
    }

    /**
     * Show booking page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function booking(Request $request, $slug, Tour $tourModel)
    {
        $tour = $tourModel->getTourBySlug($slug);
        $people = $request->people;
        $departureTime = $request->departure_time;

        return view('booking', compact(['tour', 'people', 'departureTime']));
    }

    /**
     * Store booking
     *
     * @param Request $request
     * @param $slug
     * @param Tour $tourModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBooking(Request $request, $slug, Tour $tourModel)
    {
        $tour = $tourModel->getTourBySlug($slug);
        $request->validate($this->clientService->ruleBooking());

        try {
            $this->clientService->storeBooking($request, $tour);

            $this->notification->setMessage('Successful tour booking', Notification::SUCCESS);
            return redirect()->route('index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('The tour booking failed', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Display contact page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Store contact
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeContact(Request $request)
    {
        $request->validate($this->clientService->ruleContact());
        try {
            $this->clientService->storeContact($request);
            $this->notification->setMessage('Contact sent successfully', Notification::SUCCESS);

            return redirect()->route('index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Contact sent failed', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Display search page.
     *
     * @param Request $request
     * @param Type $type
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function search(Request $request, Type $type)
    {
        $types = $type->getOrderByTitle();
        $tours = $this->clientService->searchTour($request);

        return view('search', compact(['tours', 'types']));
    }
}
