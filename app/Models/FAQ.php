<?php

namespace App\Models;

use App\Libraries\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    protected $fillable = ['tour_id', 'question','answer','status'];
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Get a list of itinerary
     *
     * @param $tourId
     * @return mixed
     */
    public function getListFAQs($tourId)
    {
        return $this->where('tour_id', $tourId)->oldest()->get();
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
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->addColumn('action', function ($data) {
                return '<button data-id="' . $data->id . '" type="button" class="btn btn-success btn-sm rounded-0 text-white edit" data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="' . route("itineraries.destroy",[$data->tour_id, $data->id]) . '" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['name', 'place','action'])
            ->make(true);
    }
}
