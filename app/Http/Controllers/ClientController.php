<?php

namespace App\Http\Controllers;

use App\Models\Destination;
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
        $trendingTours = Tour::where('status', 1)->where('trending', 1)->limit(8)->get();
        $tours = Tour::where('status', 1)->latest()->limit(8)->get();

        return view('index', compact(['destinations', 'trendingTours', 'tours']));
    }

    /**
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function listTour()
    {
        return view('list_tour');
    }

    /**
     * Show tour detail.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour()
    {
        return view('tour_detail');
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
