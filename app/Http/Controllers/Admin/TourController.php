<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\Type;
use Illuminate\Http\Request;
use Exception;

class TourController extends Controller
{
    protected $tour;
    protected $notification;

    public function __construct(Tour $tour, Notification $notification)
    {
        $this->tour = $tour;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Destination $destination, Type $type)
    {
        $destinations = $destination->getLatest();
        $types = $type->getLatest();
        return view('admin.tours.index', compact(['destinations', 'types']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Destination $destination, Type $type)
    {
        $destinations = $destination->getLatest();
        $types = $type->getLatest();
        return view('admin.tours.create', compact(['destinations', 'types']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->tour->rules());
        try {
            $this->tour->saveTour($request);
            $this->notification->setMessage('New tour added successfully', Notification::SUCCESS);

            return redirect()->route('tours.index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Tour creation failed', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id, Destination $destination, Type $type)
    {
        $tour = Tour::findorFail($id);
        $destinations = $destination->getLatest();
        $types = $type->getLatest();
        return view('admin.tours.edit', compact(['tour', 'destinations', 'types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function update(Request $request, int $id)
    {
        Tour::findOrFail($id);
        $request->validate($this->tour->rules($id));

        try {
            $messageCode = $this->tour->saveTour($request, $id);
            $this->notification->setMessage('Tour updated successfully', Notification::SUCCESS);

            if ($messageCode == 2) {
                return back()->withErrors(['duration' => 'The duration is less than number of itineraries'])->withInput();
            }

            if ($request->ajax()) {
                return json_encode($this->notification->getMessage());
            }

            return redirect()->route('tours.index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Cập nhật thông tin tour không thành công', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->tour->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->tour->getListTours($request);
            return $this->tour->getDataTable($data);
        }
    }

    /**
     * Edit info for tour.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function info(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        return view('admin.tours.info', compact('tour'));
    }
}
