<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    protected $tour;
    protected $notification;

    public function __construct(Tour $tour, Notification $notification)
    {
        $this->tour = $tour;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Destination $destination, Type $type)
    {
        $destinations = $destination->getLatest();
        $types = $type->getLatest();
        return view('admin.tours.index', compact(['destinations', 'types']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Destination $destination, Type $type)
    {
        $destinations = $destination->getLatest();
        $types = $type->getLatest();
        return view('admin.tours.create', compact(['destinations', 'types']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->tour->rules(), [], [
            'name' => 'tên',
            'slug' => 'tên rút gọn',
            'image' => 'ảnh',
            'destination_id' => 'địa điểm',
            'type_id' => 'thể loại',
            'duration' => 'thời gian',
            'price' => 'giá',
            'status' => 'trạng thái',
            'trending' => 'ưu tiên',
            'image_seo' => 'ảnh seo',
            'meta_title' => 'tiêu đề thẻ meta',
            'meta_description' => 'mô tả thẻ meta',
            'panoramic_image' => 'ảnh',
            'video' => 'video',
        ]);
        try {
            $this->tour->saveTour($request);
            $this->notification->setMessage('Tour mới đã được thêm thành công', Notification::SUCCESS);

            return redirect()->route('tours.index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Tạo tour không thành công', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id, Destination $destination, Type $type)
    {
        $tour = Tour::findorFail($id);
        $destinations = $destination->getLatest();
        $types = $type->getLatest();
        return view('admin.tours.edit', compact(['tour', 'destinations', 'types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function update(Request $request, int $id)
    {
        Tour::findOrFail($id);
        $request->validate($this->tour->rules($id), [], [
            'name' => 'tên',
            'slug' => 'tên rút gọn',
            'image' => 'ảnh',
            'destination_id' => 'địa điểm',
            'type_id' => 'thể loại',
            'duration' => 'thời gian',
            'price' => 'giá',
            'status' => 'trạng thái',
            'trending' => 'ưu tiên',
            'image_seo' => 'ảnh seo',
            'meta_title' => 'tiêu đề thẻ meta',
            'meta_description' => 'mô tả thẻ meta',
            'panoramic_image' => 'ảnh',
            'video' => 'video',
        ]);

        try {
            $messageCode = $this->tour->saveTour($request, $id);
            $this->notification->setMessage('Đã cập nhật tour thành công', Notification::SUCCESS);

            if ($messageCode == 2) {
                return back()->withErrors(['duration' => 'Thời gian không được ít hơn số lượng hành trình'])->withInput();
            }

            if ($request->ajax()) {
                return json_encode($this->notification->getMessage());
            }

            return redirect()->route('tours.index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Cập nhật thông tin tour không thành công', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->tour->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->tour->getListTours($request);
            return $this->tour->getDataTable($data);
        }
    }

    public function getChartData(Request $request)
    {
        $startDate = new Carbon($request->startDate);
        $endDate = (new Carbon($request->endDate))->addDay();
        $bookings = Booking::select('tour_id', DB::raw('count(*) as total'))
            ->where('status', '!=', BOOKING_CANCEL)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<', $endDate)
            ->groupBy('tour_id')
            ->orderBy('total', 'desc')
            ->get()->toArray();

        $arrTourId = [];
        $arrNumber = [];
        foreach ($bookings as $booking) {
            $arrTourId[] = $booking['tour_id'];
            $arrNumber[] = $booking['total'];
        }

        $tours = Tour::whereIn('id', $arrTourId)->get();

        $arrTourName = [];
        foreach ($arrTourId as $id) {
            foreach ($tours as $tour) {
                if ($tour->id == $id) {
                    $arrTourName[] = $tour->name;
                }
            }
        }

        return response()->json([
            'tours' => [
                'number' => $arrNumber,
                'name' => $arrTourName,
            ]
        ]);
    }

    /**
     * Edit info for tour.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function info(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        return view('admin.tours.info', compact('tour'));
    }
}
