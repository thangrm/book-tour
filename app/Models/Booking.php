<?php

namespace App\Models;

use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Booking extends Model
{
    use HasFactory;

    /**
     * Get the tour that owns the booking.
     *
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the customer that owns the booking.
     *
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Validate rules for booking
     *
     * @return array[]
     */
    public function rule(): array
    {
        return ['status' => 'required|integer|between:1,4'];
    }

    /**
     * Update status for booking
     *
     * @param Request $request
     * @param $id
     * @return false
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = $this->findOrFail($id);
        $diffStatus = $request->status - $booking->status;
        $booking->status = $request->status;

        if ($diffStatus != 1 && $request->status != 4) {
            return false;
        }
        return $booking->save();
    }

    /**
     * Get a list of destinations
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getList(Request $request)
    {
        $data = $this->latest()->with('tour.type', 'tour.destination', 'customer')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('customer_name', function ($data) {
                return $data->customer->first_name . ' ' . $data->customer->last_name;
            })
            ->editColumn('price', function ($data) {
                return number_format($data->price, 2) . ' $';
            })
            ->editColumn('payment_method', function ($data) {
                switch ($data->payment_method) {
                    case 1:
                        return 'Cash';
                    case 2:
                        return 'CreditCard';
                    case 3:
                        return 'Paypal';
                    default:
                        return null;
                }
            })
            ->editColumn('status', function ($data) {
                switch ($data->status) {
                    case 1:
                        return 'New';
                    case 2:
                        return 'Confirmed';
                    case 3:
                        return 'Completed';
                    case 4:
                        return 'Cancel';
                    default:
                        return null;
                }
            })
            ->addColumn('total', function ($data) {
                return number_format($data->price * $data->people, 2) . ' $';
            })
            ->addColumn('action', function ($data) {
                $link = route('bookings.show', $data->id);

                return view('admin.components.button_link_info', ['link' => $link, 'title' => 'Detail']);
            })
            ->make(true);
    }
}
