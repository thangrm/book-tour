<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;
use App\Libraries\Utilities;

class DestinationController extends Controller
{
    protected $destination;

    public function __construct(Destination $destination)
    {
        $this->destination = $destination;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.destinations.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->destination->rule());
        $notification = $this->destination->storeDestination($request);
        if ($notification['alert-type'] == 'error') {
            return redirect()->back()->with($notification);
        }
        return redirect()->route('destination.index')->with($notification);
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
        $destination = Destination::find($id);
        return view('admin.destinations.edit', compact('destination'));
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
        $request->validate($this->destination->ruleUpdate($id));
        $notification = $this->destination->updateDestination($request, $id);
        if ($notification['alert-type'] == 'error') {
            return redirect()->back()->with($notification);
        }
        return redirect()->route('destination.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->destination->desploy($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $data = $this->destination->getListDestination($request);
        return $this->destination->getDataTable($data);
    }
}
