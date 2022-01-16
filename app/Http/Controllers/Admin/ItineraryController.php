<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return View|Response
     */
    public function index($tourId)
    {
        return view('admin.itineraries.index', compact('tourId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $tourId
     * @return false|RedirectResponse|string
     */
    public function store(Request $request, $tourId)
    {
        $request->validate($this->itinerary->rules());
        $notification = $this->itinerary->storeItinerary($request, $tourId);

        return json_encode($notification->getMessage());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $tourId
     * @param $id
     * @return false|string
     */
    public function update(Request $request, $tourId, $id)
    {
        $request->validate($this->itinerary->rules(true));
        $notification = $this->itinerary->updateItinerary($request, $tourId, $id);

        return json_encode($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $tour_id
     * @param $id
     * @return Response
     */
    public function destroy($tour_id, $id)
    {
        return $this->itinerary->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @param $tour_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, $tour_id)
    {
        if ($request->ajax()) {
            return $this->itinerary->getList($tour_id);
        }
    }
}
