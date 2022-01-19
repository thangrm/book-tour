<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Itinerary;
use App\Models\Place;
use App\Models\Tour;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
    protected $place;
    protected $notification;

    public function __construct(Place $place, Notification $notification)
    {
        $this->place = $place;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index($tourId, $itineraryId)
    {
        $itinerary = Itinerary::findOrFail($itineraryId);
        return view('admin.places.index', compact('itinerary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Response
     */
    public function create($tourId, $itineraryId)
    {
        $itinerary = Itinerary::findOrFail($itineraryId);
        return view('admin.places.create', compact('itinerary'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $tourId
     * @param $itineraryId
     * @return RedirectResponse
     */
    public function store(Request $request, $tourId, $itineraryId)
    {
        $request->validate($this->place->rules());

        try {
            $this->notification->setMessage('New place added successfully', Notification::SUCCESS);
            $this->place->saveData($request, $itineraryId);

            return redirect()->route('places.index', [$tourId, $itineraryId])->with($this->notification->getMessage());
        } catch (QueryException $e) {
            $exMessage = $e->getMessage();

            if ($e->errorInfo[1] == '1062') {
                return back()->withErrors(['name' => 'The place already exists'])->withInput();
            }
        } catch (Exception $e) {
            $exMessage = $e->getMessage();
        }

        $this->notification->setMessage('Place addition failed', Notification::ERROR);

        return back()
            ->with('exception', $exMessage)
            ->with($this->notification->getMessage())
            ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View|Response
     */
    public function edit($tourId, $itineraryId, $id)
    {
        $tour = Tour::findOrFail($tourId);
        $itinerary = Itinerary::findOrFail($itineraryId);
        $place = Place::findOrFail($id);
        return view('admin.places.edit', compact(['tour', 'itinerary', 'place']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $tourId
     * @param $itineraryId
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $tourId, $itineraryId, $id)
    {
        $request->validate($this->place->rules($id));
        try {
            $this->notification->setMessage('Place updated successfully', Notification::SUCCESS);
            $this->place->saveData($request, $itineraryId, $id);

            return redirect()->route('places.index', [$tourId, $itineraryId])->with($this->notification->getMessage());
        } catch (QueryException $e) {
            $exMessage = $e->getMessage();

            if ($e->errorInfo[1] == '1062') {
                return back()->withErrors(['name' => 'The place already exists'])->withInput();
            }
        } catch (Exception $e) {
            $exMessage = $e->getMessage();
        }

        $this->notification->setMessage('Place update failed', Notification::ERROR);

        return back()
            ->with('exception', $exMessage)
            ->with($this->notification->getMessage())
            ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($tourId, $itinerary, $id)
    {
        return $this->place->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @param $tourId
     * @param $itineraryId
     * @return JsonResponse
     * @throws Exception
     */
    public function getData(Request $request, $tourId, $itineraryId)
    {
        if ($request->ajax()) {
            return $this->place->getList($tourId, $itineraryId);
        }
    }
}
