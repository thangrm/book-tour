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
}
