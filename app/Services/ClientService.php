<?php

namespace App\Services;

use App\Jobs\SendMailBookingJob;
use App\Libraries\Utilities;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Destination;
use App\Models\Room;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClientService
{
    /**
     * Rule for store new booking tour
     *
     * @return string[]
     */
    public function ruleBooking(): array
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/',
            'phone' => 'required|regex:/(0)[0-9]{9,10}/',
            'people' => 'required|integer|min:0|max:20',
            'departure_time' => 'required|date',
            'payment_method' => 'required|integer|min:0|max:3',
            'address' => 'string|max:100|nullable',
            'city' => 'string|max:50|nullable',
            'province' => 'string|max:50|nullable',
            'country' => 'string|max:25|nullable',
            'zipcode' => 'integer|nullable',
        ];
    }

    /**
     * Store booking when user book tour
     *
     * @param Request $request
     * @param $tour
     * @return void
     */
    public function storeBooking(Request $request, $tour)
    {
        $input = Utilities::clearAllXSS($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'address',
            'city',
            'province',
            'country',
            'zipcode',
        ]));
        $input['status'] = 1;
        $customer = Customer::create($input);
        $room = Room::findOrFail($request->room_id);

        $input = Utilities::clearAllXSS($request->only([
            'people',
            'payment_method',
            'departure_time',
            'requirement',
            'room_id',
            'number_room'
        ]));
        $input['customer_id'] = $customer->id;
        $input['tour_id'] = $tour->id;
        $input['price'] = $tour->price;
        $input['total'] = $tour->price * $request->people + $room->price * $request->number_room;
        $input['status'] = 1;
        $booking = Booking::create($input);

        dispatch(new SendMailBookingJob($booking));
    }

    /**
     * get filter
     *
     * @param Request $request
     * @param $query
     * @return mixed
     */
    public function filterTour(Request $request, $query)
    {
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $filterDuration = $request->filter_duration;
        $filterType = $request->filter_type;

        if (is_numeric($minPrice) && is_numeric($maxPrice)) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        if (!empty($filterDuration)) {
            $query->where(function ($query) use ($filterDuration) {
                foreach ($filterDuration as $filter) {
                    if ($filter == 1) {
                        $query->whereBetween('duration', [0, 3]);
                    }

                    if ($filter == 2) {
                        $query->orwhereBetween('duration', [3, 5]);
                    }

                    if ($filter == 3) {
                        $query->orwhereBetween('duration', [5, 7]);
                    }

                    if ($filter == 4) {
                        $query->orWhere('duration', '>', 7);
                    }
                }
            });
        }

        if (!empty($filterType)) {
            $query->whereIn('type_id', $filterType);
        }

        return $query;
    }

    /**
     * Get list tour with filter
     *
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListTour(Request $request, $slug)
    {
        $specialSlug = ['all', 'new', 'trending'];
        $query = Tour::with('destination', 'type')
            ->where('status', 1)
            ->latest();

        if (!in_array($slug, $specialSlug)) {
            $destination = Destination::where('slug', $slug)->firstOrFail();
            $query->where('destination_id', $destination->id);
        }

        if ($slug == 'trending') {
            $query->where('trending', 1);
        }

        $query = $this->filterTour($request, $query);

        return $query->paginate(9);
    }

    /**
     * search tour
     *
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchTour($request)
    {
        $query = Tour::with('destination', 'type')
            ->where('status', 1);

        $tourName = $request->tour_name;
        $destinationName = $request->destination_name;
        $duration = $request->duration;

        if (!empty($tourName)) {
            $query->where('name', 'like', '%' . $tourName . '%');
        }

        if (!empty($destinationName)) {
            $query->whereHas('destination', function ($query) use ($destinationName) {
                $query->where('name', 'like', '%' . $destinationName . '%');
            });
        }

        if (!empty($duration)) {
            $query->where('duration', $duration);
        }

        $query = $this->filterTour($request, $query);

        return $query->paginate(21);
    }

    /**
     * Get list destination
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listDestination()
    {
        return Destination::latest()->paginate(12);
    }
}
