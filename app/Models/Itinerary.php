<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'name'];
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for itinerary
     *
     * @return string[]
     */
    public function rule($isUpdate = false): array
    {
        $rule = [
            'name' => 'required|string|max:150'
        ];

        if ($isUpdate) {
            $rule['id'] = 'required|integer|exists:itineraries,id';
        }

        return $rule;
    }

    /**
     * Store itinerary
     *
     * @param Request $request
     * @param $tourId
     * @return Notification
     */
    public function storeItinerary(Request $request, $tourId)
    {
        $name = Utilities::clearXSS($request->name);

        $tour = Tour::find($tourId);
        if ($tour == null) {
            $this->notification->setMessage('Tour id not found', Notification::ERROR);

            return $this->notification;
        }

        $itinerary = $this->where('tour_id', $tourId)->where('name', $name)->first();
        if ($itinerary != null) {
            $this->notification->setMessage('The itinerary already exists', Notification::ERROR);

            return $this->notification;
        }

        $countItineraries = $this->where('tour_id', $tourId)->count();
        if ($countItineraries >= $tour->duration) {
            $this->notification->setMessage('The tour is only ' . Utilities::durationToString($tour->duration),
                Notification::ERROR);

            return $this->notification;
        }

        $input = [
            'tour_id' => $tourId,
            'name' => $name
        ];
        if ($this->create($input)->exists) {
            $this->notification->setMessage('New itinerary added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Itinerary addition failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Update itinerary in database.
     *
     * @param Request $request
     * @param $tourId
     * @return Notification
     */
    public function updateItinerary(Request $request, $tourId)
    {
        $this->notification->setMessage('Itinerary update failed', Notification::ERROR);

        try {
            $itinerary = $this->findOrFail($request->id);
            $itinerary->name = Utilities::clearXSS($request->name);

            $tour = Tour::find($tourId);
            if ($tour == null) {
                $this->notification->setMessage('Tour id not found', Notification::ERROR);

                return $this->notification;
            }

            if ($itinerary->save()) {
                $this->notification->setMessage('Itinerary updated successfully', Notification::SUCCESS);
            }
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == '1062') {
                $this->notification->setMessage('The itinerary name already exists', Notification::ERROR);
            }
        }

        return $this->notification;
    }

    /**
     * Delete the itinerary by id in database.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $itinerary = $this->findOrFail($id);
        return $itinerary->delete();
    }

    /**
     * Get a list of itinerary
     *
     * @param $tour_id
     * @return mixed
     */
    public function getListItineraries($tour_id)
    {
        return $this->where('tour_id', $tour_id)->oldest()->get();
    }

    /**
     * Format data according to Datatables
     *
     * @param Collection $data
     * @return mixed
     * @throws \Exception
     */
    public function getDataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return '<span id="name' . $data->id . '">' . $data->name . '</span>';
            })
            ->addColumn('action', function ($data) {
                return '<button data-id="' . $data->id . '" type="button" class="btn btn-success btn-sm rounded-0 text-white edit" data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="' . route("itineraries.destroy",[$data->tour_id, $data->id]) . '" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }
}
