<?php

namespace App\Http\Controllers;

use App\Libraries\Utilities;
use App\Models\Destination;
use App\Models\Itinerary;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;

class ClientController extends Controller
{
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
     * Display contact page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function contact()
    {
        return view('contact');
    }
}
