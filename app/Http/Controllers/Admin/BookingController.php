<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
        $a = json_decode('{"booking_market":{"date":["2022-04-10","2022-04-11","2022-04-12","2022-04-13","2022-04-14","2022-04-15","2022-04-16","2022-04-17","2022-04-18","2022-04-19","2022-04-20","2022-04-21","2022-04-22","2022-04-23","2022-04-24","2022-04-25","2022-04-26","2022-04-27","2022-04-28","2022-04-29","2022-04-30","2022-05-01","2022-05-02","2022-05-03","2022-05-04","2022-05-05","2022-05-06","2022-05-07","2022-05-08","2022-05-09"],"success":[0,101250,1230,0,0,0,0,0,0,0,101250,0,202500,0,0,0,101250,0,1257500,202500,0,0,0,0,200000,0,0,0,0,0],"reject":[0,0,340000,0,0,0,0,0,0,0,201250,0,0,0,0,0,0,0,2641230,500000,0,0,0,0,2003750,0,0,0,0,0],"other":[0,202500,3155420,0,0,5877500,0,1160000,2316250,1621250,301250,2807500,1550000,250000,0,0,101250,0,2419980,1357500,0,0,0,0,500000,0,100000,0,0,0]}}');
        return response()->json($a);
    }
}
