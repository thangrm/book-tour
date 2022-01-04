<?php

namespace App\Models;

use App\Libraries\Notification;
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
    protected $pathDestination = 'public/images/destinations/';
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Get the tours for the destination.
     */
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Validate rules for destination
     *
     * @return array[]
     */
    public function rule($id = null): array
    {
        $rule = [
            'name' => 'required|max:100|string|unique:destinations',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
            'status' => 'required|integer|between:1,2'
        ];

        if ($id != null) {
            $rule['name'] = "required|max:100|string|unique:destinations,name,$id";
            $rule['image'] = 'image|mimes:jpeg,jpg,png,gif|max:5000';
        }

        return $rule;
    }

    /**
     * Store a new destination in database.
     *
     * @param Request $request
     * @return Notification
     */
    public function storeDestination(Request $request)
    {
        $input = $request->only('name', 'status');
        $input['slug'] = Str::slug($input['name']);
        $input = Utilities::clearAllXSS($input);

        if ($request->hasFile('image')) {
            $input['image'] = Utilities::storeImage($request, 'image', $this->pathDestination);
        } else {
            $this->notification->setMessage('No image to upload', Notification::ERROR);
            return $this->notification;
        }

        if ($this->create($input)->exists) {
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
        $destination = $this->findOrFail($id);

        $input = $request->only('name', 'status');
        $input['slug'] = Str::slug($input['name']);
        $input = Utilities::clearAllXSS($input);

        // Upload Image
        if ($request->hasFile('image')) {
            $oldImage = $destination->image;
            $input['image'] = Utilities::storeImage($request, 'image', $this->pathDestination);
            Storage::delete($this->pathDestination . $oldImage);
        }

        $destination->fill($input);
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
        $destination = $this->findOrFail($id);
        $numberTours = $destination->tours()->count();
        if ($numberTours > 0) {
            $this->notification->setMessage('The destination has tours that cannot be deleted',
                Notification::ERROR);
            return $this->notification;
        }

        if ($destination->delete()) {
            $this->notification->setMessage('Destination deleted successfully', Notification::SUCCESS);
            $image = $destination->image;
            Storage::delete($this->pathDestination . $image);
        } else {
            $this->notification->setMessage('Destination delete failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Get a list of destinations
     *
     * @param Request $request
     * @return mixed
     */
    public function getListDestinations(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $query = $this->latest();
        if (!empty($search)) {
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%');
                $sub->orwhere('slug', 'like', '%' . $search . '%');
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    /**
     * Format data to Datatables
     *
     * @param $data
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
                return '<img src="' . asset("storage/images/destinations/" . $data->image) . '" width="80" height="80">';
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
