<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'name'];
    protected $notification;

    /**
     * Get the tour that owns the itinerary.
     *
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the places for the itinerary.
     *
     */
    public function places()
    {
        return $this->hasMany(Place::class)->oldest();
    }

    /**
     * Validate rules for itinerary
     *
     * @return string[]
     */
    public function rules(int $id = null): array
    {
        return ['name' => 'required|string|max:150'];
    }

    /**
     * Save itinerary
     *
     * @param Request $request
     * @param $tourId
     * @param int $id
     * @return int
     */
    public function saveData(Request $request, $tourId, int $id = 0)
    {
        $name = Utilities::clearXSS($request->name);
        $tour = Tour::findOrFail($tourId);
        $itinerary = $this->findOrNew($id);

        if ($id == 0) {
            $input['tour_id'] = $tourId;
        }

        $numberItineraries = $tour->itineraries()->count();
        if ($numberItineraries >= $tour->duration && $id == 0) {
            return 2;
        }

        $input['name'] = $name;
        $itinerary->fill($input);
        $itinerary->save();

        return 1;
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
     * @param $tourId
     * @return mixed
     * @throws \Exception
     */
    public function getList($tourId)
    {
        $data = $this->where('tour_id', $tourId)->oldest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return 'itinerary-' . $data->id;
            })
            ->addColumn('place', function ($data) use ($tourId) {
                $title = 'List Places';
                $link = route('places.index', [$tourId, $data->id]);

                return view('components.button_link_info', compact(['link', 'title']));
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("itineraries.update", [$data->tour_id, $data->id]);
                $linkDelete = route("itineraries.destroy", [$data->tour_id, $data->id]);

                return view('components.action_modal', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['place', 'action'])
            ->make(true);
    }
}
