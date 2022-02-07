<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Itinerary;
use App\Models\Tour;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItineraryController extends Controller
{
    protected $itinerary;
    protected $notification;

    public function __construct(Itinerary $itinerary, Notification $notification)
    {
        $this->itinerary = $itinerary;
        $this->notification = $notification;
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

        try {
            $this->notification->setMessage('New itinerary added successfully', Notification::SUCCESS);
            $codeMessage = $this->itinerary->saveData($request, $tourId);

            if ($codeMessage == 2) {
                $this->notification->setMessage('Tour duration is ' . Tour::findOrFail($tourId)->duration,
                    Notification::ERROR);
            }

        } catch (QueryException $e) {
            $this->notification->setMessage('Itinerary addition failed', Notification::ERROR);

            if ($e->errorInfo[1] == '1062') {
                $this->notification->setMessage('The itinerary already exists', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Itinerary addition failed', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
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
        $request->validate($this->itinerary->rules($id));

        try {
            $this->notification->setMessage('Itinerary updated successfully', Notification::SUCCESS);
            $this->itinerary->saveData($request, $tourId, $id);

        } catch (QueryException $e) {
            $this->notification->setMessage('Itinerary update failed', Notification::ERROR);

            if ($e->errorInfo[1] == '1062') {
                $this->notification->setMessage('The itinerary already exists', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Itinerary update failed', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
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
