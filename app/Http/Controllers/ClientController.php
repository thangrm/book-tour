<?php

namespace App\Http\Controllers;

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
        return view('index');
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
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour()
    {
        return view('tour_detail');
    }

    /**
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function booking()
    {
        return view('booking');
    }
}
