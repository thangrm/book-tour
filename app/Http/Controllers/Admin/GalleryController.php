<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Exception;

class GalleryController extends Controller
{
    protected $gallery;
    protected $notification;

    public function __construct(Gallery $gallery, Notification $notification)
    {
        $this->gallery = $gallery;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $tourId
     * @return \Illuminate\Contracts\View\View
     */
    public function index($tourId)
    {
        $galleries = $this->gallery->getImages($tourId);
        return view('admin.galleries.index', compact('galleries', 'tourId'));
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
        $request->validate($this->gallery->rules());
        try {
            $this->gallery->storeGallery($request, $tourId);
            $this->notification->setMessage('New destination added successfully', Notification::SUCCESS);

            return redirect()->route('galleries.index', $tourId)->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Image addition failed', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage());
        }
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
