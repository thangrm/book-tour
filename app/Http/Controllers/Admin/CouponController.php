<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    protected $coupon;
    protected $notification;

    public function __construct(Coupon $coupon, Notification $notification)
    {
        $this->coupon = $coupon;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index()
    {
        return view('admin.coupons.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return false|RedirectResponse|string
     */
    public function store(Request $request)
    {
        $request->validate($this->coupon->rules(), [], [
            'code' => __('client.code'),
            'discount' => __('client.discount'),
            'number' => __('client.number'),
            'status' => __('client.status'),
            'start_date' => __('client.start_date'),
            'end_date' => __('client.end_date')
        ]);

        try {
            $this->notification->setMessage('Thêm mới mã giảm giá thành công', Notification::SUCCESS);
            $this->coupon->saveData($request);

        } catch (QueryException $e) {
            $this->notification->setMessage('Thêm mới mã giảm giá không thành công', Notification::ERROR);

            if ($e->errorInfo[1] == '1062') {
                $this->notification->setMessage('Mã giảm giá đã tồn tại', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Thêm mới mã giảm giá không thành công', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $tourId
     * @param $id
     * @return false|string
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->coupon->rules($id), [], [
            'code' => __('client.code'),
            'discount' => __('client.discount'),
            'number' => __('client.number'),
            'status' => __('client.status'),
            'start_date' => __('client.start_date'),
            'end_date' => __('client.end_date')
        ]);

        try {
            $this->notification->setMessage('Cập nhật thông tin mã giảm giá thành công', Notification::SUCCESS);
            $this->coupon->saveData($request, $id);

        } catch (QueryException $e) {
            $this->notification->setMessage('Cập nhật thông tin mã giảm giá thất bại', Notification::ERROR);

            if ($e->errorInfo[1] == '1062') {
                $this->notification->setMessage('Mã giảm giá đã tồn tại', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Cập nhật thông tin mã giảm giá thất bại', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $tour_id
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->coupon->remove($id);
            $this->notification->setMessage('Xóa mã giảm giá thành công', Notification::SUCCESS);

        } catch (Exception $e) {
            $this->notification->setMessage('Xóa mã giảm giá thất bại', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @param $tour_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            return $this->coupon->getList($request);
        }

        return null;
    }

    public function check(Request $request)
    {
        $now = Carbon::now();
        $coupon = Coupon::where('code', $request->code)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>', $now)
            ->first();

        if (@$coupon->number > 0) {
            return response()->json($coupon);
        }

        return response()->json([
            'message' => 'Mã giảm giá không tồn tại hoặc đã hết lượt sử dụng'
        ], 500);
    }
}
