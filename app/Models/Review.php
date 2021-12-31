<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['status'];
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for review
     *
     * @param $id
     * @return string[]
     */
    public function rule()
    {
        return ['status' => 'required|integer|between:1,2',];
    }

    public function changeStatus($id, $isBlock = false)
    {
        $review = $this->find($id);
        if ($review == null) {
            $this->notification->setMessage('Review id not found', Notification::ERROR);

            return $this->notification;
        }

        if ($isBlock) {
            $review->status = 2;
        } else {
            $review->status = 1;
        }

        if ($review->save()) {
            $this->notification->setMessage('Review change status successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Review update failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Get a list of tours
     *
     * @param Request $request
     * @return mixed
     */
    public function getListReviews(Request $request, $tourId)
    {
        $query = $this->where('tour_id', $tourId);
        $rate = $request->rate;
        $status = $request->status;

        if (!empty($rate)) {
            $query->where('rate', $rate);
        }

        if (!empty($status)) {
            $query->where('status', '=', $status);
        }

        return $query->latest()->get();
    }

    /**
     * Format data according to Datatables
     *
     * @param Collection $data
     * @return mixed
     * @throws \Exception
     */
    public function getDataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'Public';
                } else {
                    return 'Block';
                }
            })
            ->addColumn('action', function ($data) {
                if ($data->status == 1) {
                    $url = route('reviews.block', [$data->tour_id, $data->id]);
                    return '<a onclick="changeStatus(\'' . $url . '\')" class="btn btn-danger btn-sm rounded-0 text-white block" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-arrow-down"></i>
                            </a>';
                } else {
                    $url = route('reviews.public', [$data->tour_id, $data->id]);
                    return '<a onclick="changeStatus(\'' . $url . '\')" class="btn btn-success btn-sm rounded-0 text-white public" types="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-arrow-up"></i>
                            </a>';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
