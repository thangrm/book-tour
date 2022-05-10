<?php

namespace App\Models;

use App\Libraries\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Coupon extends Model
{
    use HasFactory;

    protected $table = "coupons";
    protected $guarded = [];

    /**
     * Validate rules for coupon
     *
     * @return string[]
     */
    public function rules(int $id = null): array
    {
        $rule = [
            'code' => 'required|string|between:5,20',
            'discount' => 'required|integer|between:1,100',
            'number' => 'required|integer|between:0,1000000',
            'status' => 'required|integer|between:1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];

        return $rule;
    }

    /**
     * Save coupon
     *
     * @param Request $request
     * @param int $id
     * @return int
     */
    public function saveData(Request $request, int $id = 0)
    {
        $input = $request->only('code', 'discount', 'number', 'status', 'start_date', 'end_date');
        $input = Utilities::clearAllXSS($input);
        $coupon = $this->findOrNew($id);
        $coupon->fill($input);
        $coupon->save();

        return 1;
    }

    /**
     * Delete the coupon by id in database.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $coupon = $this->findOrFail($id);
        return $coupon->delete();
    }

    /**
     * Get a list of coupon
     *
     * @param $tourId
     * @return mixed
     * @throws \Exception
     */
    public function getList($request)
    {
        $search = $request->search;
        $status = $request->status;
        $query = $this->latest();

        if (!empty($search)) {
            $query->where('code', 'like', '%' . $search . '%');
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $data = $query->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return 'coupon-' . $data->id;
            })
            ->editColumn('start_date', function ($data) {
                return Carbon::parse($data->start_date)->format('Y-m-d H:i');
            })
            ->editColumn('end_date', function ($data) {
                return Carbon::parse($data->end_date)->format('Y-m-d H:i');
            })
            ->editColumn('status', function ($data) {
                $link = route('coupons.update', $data->id);
                return view('components.button_switch', ['status' => $data->status, 'link' => $link]);
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("coupons.update", [$data->id]);
                $linkDelete = route("coupons.destroy", [$data->id]);

                return view('components.action_modal', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
