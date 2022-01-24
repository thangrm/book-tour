<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Display a Homepage.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $destinations = Destination::where('status', 1)->latest()->limit(8)->get();
        $trendingTours = Tour::where('status', 1)->with('type', 'destination')->where('trending', 1)->limit(8)->get();
        $tours = Tour::where('status', 1)->with('type', 'destination')->latest()->limit(8)->get();

        return view('index', compact(['destinations', 'trendingTours', 'tours']));
    }

    /**
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function listTour($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        $tours = Tour::with('destination', 'type')
            ->where('status', 1)
            ->where('destination_id', $destination->id)
            ->paginate(21);

        return view('list_tour', compact(['tours']));
    }

    /**
     * Show tour detail.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour(Request $request, $slug)
    {
        $tour = Tour::with('destination', 'type', 'itineraries.places')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

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
        $tour = Tour::with('destination', 'type', 'itineraries.places')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $people = $request->people;
        $departureTime = $request->departure_time;

        return view('booking', compact(['tour', 'people', 'departureTime']));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBooking(Request $request, $slug)
    {
        $tour = Tour::with('destination', 'type', 'itineraries.places')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/',
            'phone' => 'required|regex:/(0)[0-9]{9,10}/',
            'people' => 'required|integer|min:0|max:20',
            'departure_time' => 'required|string',
            'payment_method' => 'required|integer|min:0|max:3',
            'address' => 'string|max:100|nullable',
            'city' => 'string|max:50|nullable',
            'province' => 'string|max:50|nullable',
            'country' => 'string|max:25|nullable',
            'zipcode' => 'integer|nullable',
        ]);

        $input = $request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'address',
            'city',
            'province',
            'country',
            'zipcode'
        ]);
        $input['status'] = 1;

        $customer = Customer::create($input);
        $input = $request->only([
            'people',
            'payment_method',
            'departure_time',
        ]);
        $input['customer_id'] = $customer->id;
        $input['tour_id'] = $tour->id;
        $input['price'] = $tour->price;
        $input['status'] = 1;
        $booking = Booking::create($input);

        dispatch(new SendMailJob($booking));
        $this->notification->setMessage('Successful tour booking', Notification::SUCCESS);

        return redirect()->route('index')->with($this->notification->getMessage());
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
}
