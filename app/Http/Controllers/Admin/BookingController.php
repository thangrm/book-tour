<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingRoom;
use PDF;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Change status booking
     *
     * @param int $id
     * @return string
     */
    public function changeStatus(Request $request, $id)
    {
        $request->validate($this->booking->rule());
        return json_encode($this->booking->updateStatus($request, $id));
    }

    public function updateDeposit(Request $request, $id)
    {
        $request->validate([
            'deposit' => 'required|integer'
        ]);
        $booking = Booking::findOrFail($id);

        return json_encode($booking->update([
            'deposit' => $request->deposit,
        ]));
    }

    public function update(Request $request, $id)
    {
        $totalPrice = 0;
        $booking = Booking::findOrFail($id);
        $totalPrice += $booking->price * $request->people;

        foreach ($request->room as $key => $value) {
            $bookingRoom = BookingRoom::find($key);
            $bookingRoom->update([
                'number' => $value,
            ]);
            $bookingRoom->save();
            $totalPrice += $bookingRoom->price * $bookingRoom->number;
        }

        $totalPrice = $totalPrice - ($totalPrice * $booking->discount / 100);
        $booking->update([
            'people' => $request->people,
            'total' => $totalPrice,
        ]);

        return redirect()->route('bookings.show', $booking->id);
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
            return $this->booking->getList($request);
        }
    }

    public function getChartData(Request $request)
    {
        $data = $this->booking->getRevenue($request->startDate, $request->endDate);
        return response()->json([
            'booking' => $data
        ]);
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::findOrFail($id);

//        return view('admin.bookings.invoice', compact('booking'));
        $pdf = PDF::loadView('admin.bookings.invoice', compact('booking'));
        return $pdf->stream('admin.bookings.invoice')->header('Content-Type', 'application/pdf');
    }
}
