<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\TypeOfTour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    protected $tour;

    public function __construct(Tour $tour)
    {
        $this->tour = $tour;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $destinations = Destination::latest()->get();
        $types = TypeOfTour::latest()->get();
        return view('admin.tours.view', compact(['destinations', 'types']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $destinations = Destination::latest()->get();
        $types = TypeOfTour::latest()->get();
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
        $request->validate($this->tour->rule());
        $notification = $this->tour->storeTour($request);

        if ($notification->isError()) {
            return redirect()->back()->with($notification->getMessage());
        }

        return redirect()->route('tours.index')->with($notification->getMessage());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tour = Tour::findorFail($id);
        $destinations = Destination::latest()->get();
        $types = TypeOfTour::latest()->get();
        return view('admin.tours.edit', compact(['tour', 'destinations', 'types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->tour->rule($id));
        $notification = $this->tour->updateTour($request, $id);

        if ($notification->isError()) {
            return redirect()->back()->with($notification->getMessage());
        }

        return redirect()->route('tours.index')->with($notification->getMessage());
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
}
