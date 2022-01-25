<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Review;
use Illuminate\Http\Request;
use Exception;

class ReviewContrller extends Controller
{
    protected $review;
    protected $notification;

    public function __construct(Review $review, Notification $notification)
    {
        $this->review = $review;
        $this->notification = $notification;
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
     * Change status review
     *
     * @param Request $request
     * @param $tourId
     * @param $id
     * @return string
     */
    public function changeStatus(Request $request, $tourId, $id)
    {
        $request->validate($this->review->rules($id));
        try {
            $this->review->changeStatus($request, $id);
            $this->notification->setMessage('Review change status successfully', Notification::SUCCESS);

            return json_encode($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Review update failed', Notification::ERROR);

            return json_encode($this->notification->getMessage());
        }
    }

    /**
     *  Process datatable ajax request.
     *
     * @param Request $request
     * @param $tourId
     * @return mixed|void
     * @throws Exception
     */
    public function getData(Request $request, $tourId)
    {
        if ($request->ajax()) {
            return $this->review->getList($request, $tourId);
        }
    }
}
