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

    /**
     * Validate rules for place
     *
     * @param null $id
     * @return string[]
     */
    public function rules($id = null): array
    {
        return ['name' => 'required|max:150|string',];
    }

    /**
     * Save data place for the itinerary.
     *
     * @param Request $request
     * @param $itineraryId
     * @param int $id
     * @return Notification
     */
    public function saveData(Request $request, $itineraryId, int $id = 0)
    {
        Itinerary::findOrFail($itineraryId);
        $input = $request->only('name', 'description');
        $input = Utilities::clearAllXSS($input, ['description']);
        $place = $this->findOrNew($id);

        if ($id == 0) {
            $input['itinerary_id'] = $itineraryId;
        }

        $place->fill($input);
        $place->save();
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
     * @param $tourId
     * @param $itineraryId
     * @return mixed
     * @throws \Exception
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

                return view('components.action_link', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['description', 'action'])
            ->make(true);
    }
}
