<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Room;
use App\Models\Tour;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    protected $room;
    protected $notification;

    public function __construct(Room $room, Notification $notification)
    {
        $this->room = $room;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index($tourId)
    {
        return view('admin.rooms.index', compact('tourId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $tourId
     * @return false|RedirectResponse|string
     */
    public function store(Request $request, $tourId)
    {
        $request->validate($this->room->rules(), [], [
            'name' => __('client.name'),
            'price' => __('client.price')
        ]);

        try {
            $this->notification->setMessage('Đã thêm một phòng mới thành công', Notification::SUCCESS);
            $this->room->saveData($request, $tourId);

        } catch (QueryException $e) {
            $this->notification->setMessage('Thêm mới phòng không thành công', Notification::ERROR);

            if ($e->errorInfo[1] == '1062') {
                $this->notification->setMessage('Phòng đã tồn tại', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Thêm mới phòng không thành công', Notification::ERROR);
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
    public function update(Request $request, $tourId, $id)
    {
        $request->validate($this->room->rules($id), [], [
            'name' => __('client.name'),
            'price' => __('client.price')
        ]);

        try {
            $this->notification->setMessage('Cập nhật thông tin phòng thành công', Notification::SUCCESS);
            $this->room->saveData($request, $tourId, $id);

        } catch (QueryException $e) {
            $this->notification->setMessage('Cập nhật thông tin phòng thất bại', Notification::ERROR);

            if ($e->errorInfo[1] == '1062') {
                $this->notification->setMessage('Phòng đã tồn tại', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Cập nhật thông tin phòng thất bại', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $tour_id
     * @param $id
     * @return Response
     */
    public function destroy($tour_id, $id)
    {
        return $this->room->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @param $tour_id
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, $tour_id)
    {
        if ($request->ajax()) {
            return $this->room->getList($tour_id);
        }

        return null;
    }
}
