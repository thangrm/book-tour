<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Array_;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.destinations.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|string|unique:destinations',
            'image' => 'image|mimes:jpeg,jpg,png,gif|required|max:5000',
        ]);
        $nameDestination = Utilities::clearXSS($request->name);
        $data['name'] = $nameDestination;
        $data['slug'] = Str::slug($request->name);
        $data['status'] = 1;    // default 1: active

        // Upload Image
        $folder_path = 'public/images/destination';
        $file = $request->file('image')->getClientOriginalName();
        $file_name = Str::slug(pathinfo($file, PATHINFO_FILENAME));
        $extension = $request->file('image')->getClientOriginalExtension();

        $image_name = date('mdYHis') . uniqid() . $file_name . '.' . $extension;
        $request->file('image')->storeAs($folder_path, $image_name);
        $data['image'] = $image_name;

        Destination::create($data);

        $notification = array(
            'message' => 'New destination added successfully',
            'alert-type' => 'success',
        );
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function getData(Request $request)
    {
        $data = $this->destination->getListDestination($request);
        return $this->destination->getDataTable($data);
    }
}
