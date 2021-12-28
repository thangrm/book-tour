<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Tour extends Model
{
    use HasFactory;

    /**
     * Get the destination that owns the tour.
     *
     */
    public function destination()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the type that owns the tour.
     *
     */
    public function type()
    {
        return $this->belongsTo(TypeOfTour::class);
    }

    /**
     * Get a list of tour
     *
     * @param Request $request
     * @return mixed
     */
    public function getListTour(Request $request)
    {
        $search = $request->search;
        $destinationId = $request->destination_id;
        $typeId = $request->type_id;
        $status = $request->status;

        $query = DB::table('tours')
            ->join('destinations', 'tours.destination_id', '=', 'destinations.id')
            ->join('tour_types', 'tours.type_id', '=', 'tour_types.id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('tours.name', 'like', '%' . $search . '%');
                $query->orwhere('tours.slug', 'like', '%' . $search . '%');
            });
        }

        if (!empty($destinationId)) {
            $query->where('tours.destination_id', '=', $destinationId);
        }

        if (!empty($typeId)) {
            $query->where('tours.type_id', '=', $typeId);
        }

        if (!empty($status)) {
            $query->where('tours.status', '=', $status);
        }
        $query->select('tours.*', 'destinations.name AS destination_name', 'tour_types.name AS type_name');
        return $query->latest()->get();

    }

    /**
     * Format data according to Datatables
     *
     * @param Collection $data
     * @return mixed
     * @throws \Exception
     */
    public
    function getDataTable(
        $data
    ) {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return "<b>$data->name </b> <br>
                        $data->destination_name  ($data->type_name)";
            })
            ->editColumn('image', function ($data) {
                return '<img src="' . asset("storage/images/tours/" . $data->image) . '" width="80" height="80">';
            })
            ->editColumn('price', function ($data) {
                return number_format($data->price, 2) . ' $';;
            })
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->editColumn('trending', function ($data) {
                if ($data->status == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->addColumn('detail', function ($data) {
                return '<a class="btn btn-info text-white mt-1" style="width: 80px">Info</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Gallery</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Itinerary</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Faqs</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Review</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Bookings</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Contact</a>
                        ';
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route("tours.edit", $data->id) . '" class="btn btn-success btn-sm rounded-0 text-white edit" types="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="' . route("tours.destroy", $data->id) . '" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['name', 'image', 'status', 'detail', 'action'])
            ->make(true);
    }
}
