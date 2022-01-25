<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'rate', 'comment', 'tour_id'];

    /**
     * Validate rules for review
     *
     * @return string[]
     */
    public function rules($id = null)
    {
        $rule = [
            'rate' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:10000',
        ];

        if ($id != null) {
            $rule = ['status' => 'required|integer|between:1,2'];
        }

        return $rule;
    }

    /**
     * Store a new review for tour in database.
     *
     */
    public function saveData(Request $request, Tour $tour)
    {
        $input = Utilities::clearAllXSS($request->only('rate', 'comment'));
        $input['tour_id'] = $tour->id;
        $input['status'] = 1;

        Review::create($input);
    }

    /**
     * Change the status of the review to public or block
     *
     * @param Request $request
     * @param $id
     * @return void
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
    public function getList(Request $request, $tourId)
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
            ->editColumn('rate', function ($data) {
                return view('components.rate', ['rate' => $data->rate]);
            })
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
