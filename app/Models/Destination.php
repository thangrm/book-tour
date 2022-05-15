<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Traits\GetListData;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Destination extends Model
{
    use HasFactory, GetListData;

    protected $guarded = [];
    protected $path = 'public/images/destinations/';
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
    public function rules($id = null): array
    {
        $rule = [
            'name' => 'required|max:100|string',
            'slug' => 'required|max:100|string|unique:destinations',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
            'status' => 'required|integer|between:1,2'
        ];

        if ($id != null) {
            $rule['name'] = "max:100|string";
            $rule['slug'] = "max:100|string|unique:destinations,slug,$id";
            $rule['image'] = 'image|mimes:jpeg,jpg,png,gif|max:5000';
            $rule['status'] = 'integer|between:1,2';
        }

        return $rule;
    }

    /**
     * Save data for destination in database.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function saveData(Request $request, int $id = 0)
    {
        $input = $request->only('name', 'slug', 'status');
        $input = Utilities::clearAllXSS($input);

        $destination = $this->findOrNew($id);
        $oldImage = $destination->image;

        if ($request->hasFile('image')) {
            $input['image'] = Utilities::storeImage($request->file('image'), $this->path);
        }

        $destination->fill($input);
        $destination->slug = Str::slug($destination->slug);
        if ($destination->save()) {
            if ($request->hasFile('image')) {
                Storage::delete($this->path . $oldImage);
            }
        } else {
            Storage::delete($this->path . $destination->image);
        }
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
            $this->notification->setMessage('Điểm đến đã có các tours du lịch không thể xóa',
                Notification::WARNING);
            return $this->notification;
        }

        if ($destination->delete()) {
            $this->notification->setMessage('Đã xóa điểm đến thành công', Notification::SUCCESS);
            $image = $destination->image;
            Storage::delete($this->path . $image);
        } else {
            $this->notification->setMessage('Xóa điểm đến không thành công', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Get a list of destinations
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getList(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = $this->latest();
        if (!empty($search)) {
            $search = Utilities::clearXSS($search);
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%');
                $sub->orwhere('slug', 'like', '%' . $search . '%');
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $data = $query->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return 'destination-' . $data->id;
            })
            ->editColumn('status', function ($data) {
                $link = route('destinations.update', $data->id);

                return view('components.button_switch', ['status' => $data->status, 'link' => $link]);
            })
            ->editColumn('image', function ($data) {
                $pathImage = asset("storage/images/destinations/" . $data->image);

                return view('components.image', compact('pathImage'));
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("destinations.update", $data->id);
                $linkDelete = route("destinations.destroy", $data->id);

                return view('components.action_modal', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
