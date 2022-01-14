<?php

namespace App\Models;

use App\Libraries\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
     * @return string[]
     */
    public function rules()
    {
        $rule = ['status' => 'required|integer|between:1,2'];
        return $rule;
    }

    /**
     * Change the status of the review to public or block
     *
     * @param $id
     * @param $isBlock
     * @return Notification
     */
    public function changeStatus(Request $request, $id)
    {
        $review = $this->findOrFail($id);
        $review->status = $request->status;
        $review->save();
    }

    /**
     * Get a list of reviews
     *
     * @param Request $request
     * @param $tourId
     * @return mixed
     * @throws \Exception
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
            $query->where('status', $status);
        }

        $data = $query->latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return view('components.status', ['status' => $data->status]);
            })
            ->addColumn('action', function ($data) {
                $link = route('reviews.status', [$data->tour_id, $data->id]);
                $status = ($data->status == 1) ? 2 : 1;

                return view('components.button_change_status', compact(['link', 'status']));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
