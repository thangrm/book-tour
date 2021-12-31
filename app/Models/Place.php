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

    public function getListPlaces($itineraryId)
    {
        return $this->where('itinerary_id', $itineraryId)->oldest()->get();
    }

    /**
     * Validate rules for tour
     *
     * @return string[]
     */
    public function rule($id = null)
    {
        $rule = [
            'name' => 'required|max:150|string|unique:places',
        ];
        if($id != null){
            $rule['name'] = 'required|max:150|string|unique:places,name,' . $id;
        }
        return $rule;
    }

    public function storePlace(Request $request, $itineraryId)
    {
        $input = $request->only('name', 'description',);
        $input['itinerary_id'] = $itineraryId;
        $input = Utilities::clearAllXSS($input);

        if ($this->create($input)->exists) {
            $this->notification->setMessage('New place added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Place creation failed', Notification::ERROR);
        }

        return $this->notification;
    }

    public function updatePlace(Request $request, $itineraryId, $id)
    {
        $this->notification->setMessage('Itinerary update failed', Notification::ERROR);

        try{
            $place = $this->findOrFail($id);
            $place->name = Utilities::clearXSS($request->name);
            $place->description = $request->description;

            if ($place->save()) {
                $this->notification->setMessage('Place updated successfully', Notification::SUCCESS);
            }
        }catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == '1062') {
                $this->notification->setMessage('The place name already exists', Notification::ERROR);
            }
        }

        return $this->notification;
    }

    public function remove($id)
    {
        $itinerary = $this->findOrFail($id);
        return $itinerary->delete();
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
                return '<a  href="'.route('places.edit', [$data->itinerary_id,$data->id]).'" data-id="' . $data->id . '" type="button" class="btn btn-success btn-sm rounded-0 text-white edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="'.route('places.destroy', [$data->itinerary_id,$data->id]).'" class="btn btn-danger btn-sm rounded-0 text-white delete m-l-5" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['name','description','action'])
            ->make(true);
    }
}
