<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeOfTour;
use Illuminate\Http\Request;

class TypeOfTourController extends Controller
{
    protected $typeTour;

    public function __construct(TypeOfTour $typeTour)
    {
        $this->typeTour = $typeTour;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.types.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->typeTour->rule());
        $notification = $this->typeTour->storeType($request);

        if ($notification->isError()) {
            return redirect()->back()->with($notification->getMessage());
        }

        return redirect()->route('types.index')->with($notification->getMessage());
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
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $type = TypeOfTour::findOrFail($id);
        $type->tours;
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->typeTour->rule($id));
        $notification = $this->typeTour->updateType($request, $id);

        if ($notification->isError()) {
            return redirect()->back()->with($notification->getMessage());
        }

        return redirect()->route('types.index')->with($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return String
     */
    public function destroy($id)
    {
        return json_encode($this->typeTour->remove($id)->getMessage());
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->typeTour->getListTypes($request);
            return $this->typeTour->getDataTable($data);
        }
    }
}
