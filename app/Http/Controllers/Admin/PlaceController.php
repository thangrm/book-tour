<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use App\Models\Place;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
    protected $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index($itineraryId)
    {
        $itinerary = Itinerary::findOrFail($itineraryId);
        return view('admin.places.view', compact('itinerary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Response
     */
    public function create($itineraryId)
    {
        $itinerary = Itinerary::findOrFail($itineraryId);
        return view('admin.places.create', compact('itinerary'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $itineraryId
     * @return RedirectResponse
     */
    public function store(Request $request, $itineraryId)
    {
        $request->validate($this->place->rule());
        $notification = $this->place->storePlace($request, $itineraryId);

        if ($notification->isError()) {
            return back()->with($notification->getMessage())->withInput();
        }

        return redirect()->route('places.index', $itineraryId)->with($notification->getMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View|Response
     */
    public function edit($itineraryId, $id)
    {
        $itinerary = Itinerary::findOrFail($itineraryId);
        $place = Place::findOrFail($id);
        return view('admin.places.edit', compact(['itinerary', 'place']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $itineraryId
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $itineraryId, $id)
    {
        $request->validate($this->place->rule());
        $notification = $this->place->updatePlace($request, $itineraryId, $id);

        if ($notification->isError()) {
            return redirect()->back()->with($notification->getMessage())->withInput();
        }

        return redirect()->route('places.index', $itineraryId)->with($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($itinerary, $id)
    {
        return $this->place->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @param $itineraryId
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, $itineraryId)
    {
        if ($request->ajax()) {
            $data = $this->place->getListPlaces($itineraryId);
            return $this->place->getDataTable($data);
        }
    }
}
