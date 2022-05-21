<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\Type;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $numberDestinations = Destination::where('status', ACTIVE)->count();
        $numberTypes = Type::where('status', ACTIVE)->count();
        $numberTours = Tour::where('status', ACTIVE)->count();
        $numberBookings = Booking::count();
        $tours = Tour::orderBy('name')->get();

        return view('admin.dashboard',
            compact(['numberDestinations', 'numberTypes', 'numberTours', 'numberBookings', 'tours']));
    }
}
