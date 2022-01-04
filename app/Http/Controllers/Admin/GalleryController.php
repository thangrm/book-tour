<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $gallery;

    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $tourId
     * @return \Illuminate\Contracts\View\View
     */
    public function index($tourId)
    {
        $galleries = $this->gallery->getImagesByTourId($tourId);
        return view('admin.galleries.view', compact('galleries', 'tourId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $tourId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $tourId)
    {
        $request->validate($this->gallery->rule());
        $notification = $this->gallery->storeGallery($request, $tourId);
        if ($notification->isError()) {
            return back()->with($notification->getMessage());
        }

        return redirect()->route('galleries.index', $tourId)->with($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($tour_id, $id)
    {
        return json_encode($this->gallery->remove($id));
    }
}
