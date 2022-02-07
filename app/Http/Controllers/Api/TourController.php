<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\TourCollection;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $tours = Tour::with('itineraries.places')->paginate(100);
        return (new TourCollection($tours))->additional([
            'add-tour' => [
                'key' => 'value',
            ]
        ]);;

//        return TourResource::collection($tours);
        return (new TourResource(Tour::with('itineraries.places')->find(13)))
            ->additional([
                'add-itineraries' => [
                    'key' => 'value',
                ]
            ]);
//        return response()->json($tour, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tour $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        return $tour;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tour $tour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tour $tour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tour $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tour $tour)
    {
        //
    }
}
