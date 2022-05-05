<?php

namespace App\Models;

use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $notification;

    /**
     * Get the tour that owns the room.
     *
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Validate rules for itinerary
     *
     * @return string[]
     */
    public function rules(int $id = null): array
    {
        return [
            'name' => 'required|string|max:150',
            'price' => 'required|integer|min:0',
        ];
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
        $room = $this->findOrNew($id);

        if ($id == 0) {
            $input['tour_id'] = $tourId;
        }

        $input['name'] = $name;
        $input['price'] = $request->price;
        $room->fill($input);
        $room->save();

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
        $room = $this->findOrFail($id);
        return $room->delete();
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
                return 'Room-' . $data->id;
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("rooms.update", [$data->tour_id, $data->id]);
                $linkDelete = route("rooms.destroy", [$data->tour_id, $data->id]);

                return view('components.action_modal', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['place', 'action'])
            ->make(true);
    }
}
