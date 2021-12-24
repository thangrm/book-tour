<?php

namespace App\Models;

use App\Libraries\Utilities;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $path_save_image = 'public/images/destination';

    public function rule(): array
    {
        return [
            'name' => 'required|max:100|string|unique:destinations',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
        ];
    }

    public function ruleUpdate($id): array
    {
        return [
            'name' => "required|max:100|string|unique:destinations,name,$id",
            'image' => "image|mimes:jpeg,jpg,png,gif|max:5000",
            'status' => "required|between:1,2"
        ];
    }

    public function storeDestination(Request $request)
    {
        $nameDestination = Utilities::clearXSS($request->name);
        $data['name'] = $nameDestination;
        $data['slug'] = Str::slug($nameDestination);
        $data['status'] = 1;    // default 1: active

        $image = $this->storeImage($request);
        $data['image'] = $image;
        if (Destination::create($data)->exists) {
            $notification = array(
                'message' => 'New destination added successfully',
                'alert-type' => 'success',
            );
        } else {
            $notification = array(
                'message' => 'Destination creation failed',
                'alert-type' => 'error',
            );
        }

        return $notification;
    }

    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::find($id);

        $name_destination = Utilities::clearXSS($request->name);
        $destination->name = $name_destination;
        $destination->slug = Str::slug($name_destination);
        $destination->status = $request->status;

        // Upload Image
        if ($request->hasFile('image')) {
            $old_image = $destination->image;
            $image = $this->storeImage($request);
            Storage::delete($this->path_save_image, $old_image);
            $destination->image = $image;
        }

        if ($destination->save()) {
            $notification = array(
                'message' => 'Destination updated successfully',
                'alert-type' => 'success',
            );
        } else {
            $notification = array(
                'message' => 'Destination update failed',
                'alert-type' => 'error',
            );
        }

        return $notification;
    }

    protected function storeImage(Request $request)
    {
        $file = $request->file('image')->getClientOriginalName();
        $file_name = Str::slug(pathinfo($file, PATHINFO_FILENAME));
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $image_name = date('mdYHis') . uniqid() . $file_name . '.' . $extension;
        $request->file('image')->storeAs($this->path_save_image, $image_name);
        return $image_name;
    }

    public function getListDestination(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        if (!empty($search) && !empty($status)) {
            return $this->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orwhere('slug', 'like', '%' . $search . '%');
            })
                ->where('status', '=', $status)
                ->orderBy('id', 'asc')->get();

        } elseif (!empty($search)) {
            return $this->where('name', 'like', '%' . $search . '%')
                ->orwhere('slug', 'like', '%' . $search . '%')
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
            ->editColumn('image', function ($data) {
                return '<img src="' . asset("storage/images/destination/" . $data->image) . '" width="80" height="80">';
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route("destination.edit", $data->id) . '" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="' . route("destination.edit", $data->id) . '" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }
}
