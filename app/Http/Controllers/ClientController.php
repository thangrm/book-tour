<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailBookingJob;
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
        $destinations = $destination->getListActive(8);
        $types = $type->getListActive();
        $trendingTours = $tour->getTourActive(true, 8);
        $tours = $tour->getTourActive(false, 8);

        return view('index', compact(['destinations', 'trendingTours', 'types', 'tours']));
    }

    /**
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function listTour(Request $request, $slug)
    {
        $types = Type::orderBy('name')->get();
        $tours = $this->clientService->getListTour($request, $slug);

        return view('list_tour', compact(['tours', 'types']));
    }

    /**
     * Show tour detail.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour(Request $request, $slug)
    {
        $tour = $this->clientService->getTourBySlug($slug);

        $tour->faqs = $tour->faqs()
            ->where('status', 1)
            ->get();

        $tour->reviews = $tour->reviews()
            ->where('status', 1)
            ->get();

        $relateTours = Tour::with('destination', 'type')
            ->where('status', 1)
            ->where('destination_id', $tour->destination_id)
            ->limit(6)
            ->get();

        $reviews = $tour->reviews()
            ->where('status', 1)
            ->paginate(8);


        $rateReview = Utilities::calculatorRateReView($tour->reviews);

        return view('tour_detail', compact(['tour', 'relateTours', 'reviews', 'rateReview']));
    }

    /**
     * Show booking page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function booking(Request $request, $slug)
    {
        $tour = $this->clientService->getTourBySlug($slug);
        $people = $request->people;
        $departureTime = $request->departure_time;

        return view('booking', compact(['tour', 'people', 'departureTime']));
    }

    /**
     * Store booking
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBooking(Request $request, $slug)
    {
        $tour = $this->clientService->getTourBySlug($slug);
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $types = Type::orderBy('name')->get();
        $tours = $this->clientService->searchTour($request);

        return view('search', compact(['tours', 'types']));
    }
}
