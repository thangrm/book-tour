<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Tour;
use Carbon\Carbon;
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
            'price' => __('client.price'),
            'number' => __('client.number'),
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
            'price' => __('client.price'),
            'number' => __('client.number'),
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

    public function getRoomByTourId(Request $request)
    {
        $rooms = Room::where('tour_id', $request->tour_id)->get();

        $data = [];
        foreach ($rooms as $room) {
            $data[] = [
                'id' => $room->id,
                'name' => $room->name . ' - ' . number_format($room->price) . 'đ',
            ];
        }
        return response()->json([
            'rooms' => $data,
        ]);
    }

    public function getChartData(Request $request)
    {
        $arrDates = Utilities::dateRange($request->startDate, $request->endDate);
        $tour = Tour::find($request->tour_id);

        $arrRented = [];
        $arrAvailable = [];
        foreach ($arrDates as $date) {
            $result = $this->checkRoom($tour, $date);

            if ($request->room_id == 0) {
                $arrRented[] = array_sum($result['rented']);
                $arrAvailable[] = array_sum($result['available']);
            } else {
                $arrRented[] = $result['rented'][$request->room_id];
                $arrAvailable[] = $result['available'][$request->room_id];
            }
        }

        return response()->json([
            'room' => [
                'date' => $arrDates,
                'rented' => $arrRented,
                'available' => $arrAvailable,
            ]
        ]);
    }

    public function checkRoom($tour, $date)
    {
        $offsetDate = ($tour->duration - 1) * -1;
        $startDate = Carbon::parse($date)->addDays($offsetDate);
        $endDate = Carbon::parse($date);
        $bookings = Booking::where('status', '!=', BOOKING_CANCEL)
            ->with('booking_room')
            ->whereDate('departure_time', '>=', $startDate)
            ->whereDate('departure_time', '<=', $endDate)
            ->where('tour_id', $tour->id)
            ->get();

        $roomRented = [];
        $roomAvailable = [];
        foreach ($tour->rooms as $room) {
            $roomAvailable[$room->id] = $room->number;
            $roomRented[$room->id] = 0;
        }

        foreach ($bookings as $booking) {
            foreach ($booking->booking_room as $bookingRoom) {
                $roomAvailable[$bookingRoom->room_id] -= $bookingRoom->number;
                $roomRented[$bookingRoom->room_id] += $bookingRoom->number;
                if ($roomAvailable[$bookingRoom->room_id] < 0) {
                    $roomAvailable[$bookingRoom->room_id] = 0;
                }
            }
        }

        return [
            'available' => $roomAvailable,
            'rented' => $roomRented,
        ];
    }
}
