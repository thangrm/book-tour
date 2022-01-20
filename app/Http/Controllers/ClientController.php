<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Itinerary;
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
        $destination = Destination::where('slug', $slug)->first();
        $tours = Tour::with('destination', 'type')->where('destination_id', $destination->id)->paginate(12);
        return view('list_tour', compact(['tours']));
    }

    /**
     * Show tour detail.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour(Request $request, $slug)
    {
        $tour = Tour::with('destination', 'type', 'reviews', 'itineraries.places')
            ->where('slug', $slug)->firstOrFail();
        $relateTours = Tour::with('destination', 'type')
            ->where('destination_id', $tour->destination_id)
            ->limit(6)->get();

        return view('tour_detail', compact(['tour', 'relateTours']));
    }

    /**
     * Show booking page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function booking()
    {
        return view('booking');
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
