<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use App\Models\Tour;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    protected $itinerary;

    public function __construct(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($tourId)
    {
        return view('admin.itineraries.view', compact('tourId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $tourId)
    {
        $request->validate($this->itinerary->rule());
        $notification = $this->itinerary->storeItinerary($request, $tourId);
        if ($notification->isError()) {
            return back()->with($notification->getMessage());
        }

        return redirect()->route('itineraries.index', $tourId)->with($notification->getMessage());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return false|\Illuminate\Http\Response|string
     */
    public function update(Request $request, $tourId)
    {
        $request->validate($this->itinerary->rule(true));
        $notification = $this->itinerary->updateItinerary($request, $tourId);

        return json_encode($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request, $tour_id)
    {
        if ($request->ajax()) {
            $data = $this->itinerary->getListItineraries($tour_id);
            return $this->itinerary->getDataTable($data);
        }
    }
}
