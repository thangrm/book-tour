<?php

namespace App\Models;

use App\Libraries\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
                        <a href="" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['name','action'])
            ->make(true);
    }
}
