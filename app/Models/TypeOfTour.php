<?php

namespace App\Models;

use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TypeOfTour extends Model
{
    use HasFactory;

    protected $table = 'tour_types';
    protected $guarded = [];

    public function rule()
    {
        return [
            'name' => 'required|max:50|string|unique:tour_types',
            'status' => 'required|between:1,2'
        ];
    }

    public function storeType(Request $request)
    {
        $nameType = Utilities::clearXSS($request->name);
        $data['name'] = $nameType;
        $data['status'] = $request->status;

        if (TypeOfTour::create($data)->exists) {
            $notification = array(
                'message' => 'New type added successfully',
                'alert-type' => 'success',
            );
        } else {
            $notification = array(
                'message' => 'Type creation failed',
                'alert-type' => 'error',
            );
        }

        return $notification;
    }

    public function getListTypeTour(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        if (!empty($search) && !empty($status)) {
            return $this->where('name', 'like', '%' . $search . '%')
                ->where('status', '=', $status)
                ->orderBy('id', 'asc')->get();

        } elseif (!empty($search)) {
            return $this->where('name', 'like', '%' . $search . '%')
                ->orderBy('id', 'asc')->get();

        } elseif (!empty($status)) {
            return $this->where('status', '=', $status)
                ->orderBy('id', 'asc')->get();
        }

        return $this->orderBy('id', 'asc')->get();
    }

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
                return '<a href="' . route("types.edit", $data->id) . '" class="btn btn-success btn-sm rounded-0 text-white edit" types="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="' . route("types.destroy", $data->id) . '" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
