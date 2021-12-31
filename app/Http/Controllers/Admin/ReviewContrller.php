<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewContrller extends Controller
{
    protected $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($tourId)
    {
        return view('admin.reviews.index', compact('tourId'));
    }

    /**
     * @param Request $request
     * @param $tourId
     * @param $id
     * @return string
     */
    public function public(Request $request, $tourId, $id)
    {
        return json_encode($this->review->changeStatus($id)->getMessage());
    }

    /**
     * @param Request $request
     * @param $tourId
     * @param $id
     * @return string
     */
    public function block(Request $request, $tourId, $id)
    {
        return json_encode($this->review->changeStatus($id, true)->getMessage());
    }

    /**
     *  Process datatable ajax request.
     *
     * @param Request $request
     * @return mixed|void
     * @throws \Exception
     */
    public function getData(Request $request, $tourId)
    {
        if ($request->ajax()) {
            $data = $this->review->getListReviews($request, $tourId);
            return $this->review->getDataTable($data);
        }
    }
}
