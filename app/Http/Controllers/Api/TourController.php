<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\TourCollection;
use App\Http\Resources\TourResource;
use App\Libraries\Utilities;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TourCollection
     */
    public function index(Request $request, Tour $tour)
    {
        $request->validate([
            'page' => 'integer',
            'per_page' => 'integer|between:1,100',
            'min_price' => 'numeric|nullable',
            'max_price' => 'numeric|nullable',
            'duration' => 'integer|between:1,127|nullable',
        ]);

        return (new TourCollection($tour->getListForApi($request)));
    }

    /**
     * Display the specified resource.
     *
     * @param $tourId
     * @return TourResource
     */
    public function show($tourId)
    {
        return new TourResource(Tour::with('itineraries.places', 'destination', 'type')
            ->findOrFail($tourId));
    }
}
