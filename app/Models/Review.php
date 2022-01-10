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
        return ['status' => 'required|integer|between:1,2'];
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

        return $query->latest()->get();
    }

    /**
     * Format data to Datatables
     *
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function getDataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return ($data->status == 1) ? 'Public' : 'Block';
            })
            ->addColumn('action', function ($data) {
                $link = route('reviews.status', [$data->tour_id, $data->id]);
                $status = ($data->status == 1) ? 2 : 1;

                return view('admin.components.button_change_status', compact(['link', 'status']));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
