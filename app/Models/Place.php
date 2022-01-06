<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['itinerary_id', 'name', 'description', 'status'];
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for place
     *
     * @return string[]
     */
    public function rule()
    {
        return ['name' => 'required|max:150|string',];
    }

    /**
     * Store a new place for the itinerary.
     *
     * @param Request $request
     * @param $itineraryId
     * @return Notification
     */
    public function storePlace(Request $request, $itineraryId)
    {
        $input = $request->only('name', 'description',);
        $input['itinerary_id'] = $itineraryId;
        $input = Utilities::clearAllXSS($input);

        $itinerary = Itinerary::find($itineraryId);
        if ($itinerary == null) {
            $this->notification->setMessage('Itinerary id not found', Notification::ERROR);

            return $this->notification;
        }

        $countPlaces = $this->where('itinerary_id', $itineraryId)->where('name', $input['name'])->count();
        if ($countPlaces > 0) {
            $this->notification->setMessage('The place already exists', Notification::ERROR);

            return $this->notification;
        }

        if ($this->create($input)->exists) {
            $this->notification->setMessage('New place added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Place creation failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Update place in database
     *
     * @param Request $request
     * @param $itineraryId
     * @param $id
     * @return Notification
     */
    public function updatePlace(Request $request, $itineraryId, $id)
    {
        $this->notification->setMessage('Itinerary update failed', Notification::ERROR);

        try {
            $place = $this->findOrFail($id);
            $input = $request->only('name', 'description',);
            $input = Utilities::clearAllXSS($input);
            $place->fill($input);

            if ($place->save()) {
                $this->notification->setMessage('Place updated successfully', Notification::SUCCESS);
            }
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == '1062') {
                $this->notification->setMessage('The place name already exists', Notification::ERROR);
            }
        }

        return $this->notification;
    }

    /**
     * Delete the place by id.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $place = $this->findOrFail($id);
        return $place->delete();
    }


    /**
     * Get a list of places by itineraryId
     *
     * @param $itineraryId
     * @return mixed
     */
    public function getList($tourId, $itineraryId)
    {
        $data = $this->where('itinerary_id', $itineraryId)->oldest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) use ($tourId) {
                $id = $data->id;
                $linkEdit = route('places.edit', [$tourId, $data->itinerary_id, $data->id]);
                $linkDelete = route('places.destroy', [$tourId, $data->itinerary_id, $data->id]);

                return view('admin.components.action_link', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['description', 'action'])
            ->make(true);
    }
}
