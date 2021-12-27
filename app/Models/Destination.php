<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $path_save_image = 'public/images/destination';
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for store
     *
     * @return array[]
     */
    public function rule(): array
    {
        return [
            'name' => 'required|max:100|string|unique:destinations',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
            'status' => 'required|between:1,2'
        ];
    }

    /**
     * Validate rules for update
     *
     * @param $id
     * @return array[]
     */
    public function ruleUpdate($id): array
    {
        return [
            'name' => "required|max:100|string|unique:destinations,name,$id",
            'image' => "image|mimes:jpeg,jpg,png,gif|max:5000",
            'status' => "required|between:1,2"
        ];
    }

    /**
     * Store a new destination in database.
     *
     * @param Request $request
     * @return Notification
     */
    public function storeDestination(Request $request)
    {
        $nameDestination = Utilities::clearXSS($request->name);
        $data['name'] = $nameDestination;
        $data['slug'] = Str::slug($nameDestination);
        $data['status'] = $request->status;

        $image = $this->storeImage($request);
        $data['image'] = $image;
        if (Destination::create($data)->exists) {
            $this->notification->setMessage('New destination added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Destination creation failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Update the destination in database.
     *
     * @param Request $request
     * @param $id
     * @return Notification
     */
    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $nameDestination = Utilities::clearXSS($request->name);
        $destination->name = $nameDestination;
        $destination->slug = Str::slug($nameDestination);
        $destination->status = $request->status;

        // Upload Image
        if ($request->hasFile('image')) {
            $oldImage = $destination->image;
            $image = $this->storeImage($request);
            Storage::delete($this->path_save_image, $oldImage);
            $destination->image = $image;
        }

        if ($destination->save()) {
            $this->notification->setMessage('Destination updated successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Destination update failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Delete the destination by id in database.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $destination = Destination::findOrFail($id);

        return $destination->delete();
    }

    /**
     * Store image for the destination.
     *
     * @param Request $request
     * @return string
     */
    protected function storeImage(Request $request)
    {
        $file = $request->file('image')->getClientOriginalName();
        $file_name = Str::slug(pathinfo($file, PATHINFO_FILENAME));
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $imageName = date('mdYHis') . uniqid() . $file_name . '.' . $extension;
        $request->file('image')->storeAs($this->path_save_image, $imageName);

        return $imageName;
    }

    /**
     * Get a list of destinations
     *
     * @param Request $request
     * @return mixed
     */
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
            ->editColumn('image', function ($data) {
                return '<img src="' . asset("storage/images/destination/" . $data->image) . '" width="80" height="80">';
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route("destinations.edit", $data->id) . '" class="btn btn-success btn-sm rounded-0 text-white edit" types="button" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="' . route("destinations.destroy", $data->id) . '" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }
}
