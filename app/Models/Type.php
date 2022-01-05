<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Type extends Model
{
    use HasFactory;

    protected $table = 'tour_types';
    protected $guarded = [];
    protected $notification;


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Get the tours for the type.
     */
    public function tours()
    {
        return $this->hasMany(Tour::class, 'type_id', 'id');
    }

    /**
     * Validate rules for type
     *
     * @return array[]
     */
    public function rule($id = null): array
    {
        $rule = [
            'name' => 'required|max:50|string|unique:tour_types',
            'status' => 'required|integer|between:1,2'
        ];

        if ($id != null) {
            $rule['name'] = "required|max:50|string|unique:tour_types,name,$id";
        }

        return $rule;
    }

    /**
     * Store a new type in database.
     *
     * @param Request $request
     * @return Notification
     */
    public function storeType(Request $request)
    {
        $nameType = Utilities::clearXSS($request->name);
        $data['name'] = $nameType;
        $data['status'] = $request->status;

        if ($this->create($data)->exists) {
            $this->notification->setMessage('New type added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Type creation failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Update the type in database.
     *
     * @param Request $request
     * @param $id
     * @return Notification
     */
    public function updateType(Request $request, $id)
    {
        $type = $this->findOrFail($id);
        $nameType = Utilities::clearXSS($request->name);
        $type->name = $nameType;
        $type->status = $request->status;

        if ($type->save()) {
            $this->notification->setMessage('Type updated successfull', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Type update failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Delete the type by id in database.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $type = $this->findOrFail($id);
        $numberTours = $type->tours()->count();
        if ($numberTours > 0) {
            $this->notification->setMessage('The type has tours that cannot be deleted',
                Notification::ERROR);
            return $this->notification;
        }

        if ($type->delete()) {
            $this->notification->setMessage('Type deleted successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Type delete failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Get a list of types
     *
     * @param Request $request
     * @return mixed
     */
    public function getListTypes(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $query = $this->latest();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->get();
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
                return ($data->status == 1) ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("types.edit", $data->id);
                $linkDelete = route("types.destroy", $data->id);

                return view('admin.components.action_link', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
