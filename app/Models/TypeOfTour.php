<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TypeOfTour extends Model
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
        return $this->hasMany(Tour::class);
    }

    /**
     * Validate rules for store
     *
     * @return array[]
     */
    public function rule(): array
    {
        return [
            'name' => 'required|max:50|string|unique:tour_types',
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
            'name' => "required|max:50|string|unique:tour_types,name,$id",
            'status' => "required|between:1,2"
        ];
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

        if (TypeOfTour::create($data)->exists) {
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
        $type = TypeOfTour::findOrFail($id);
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
        $type = TypeOfTour::findOrFail($id);

        return $type->delete();
    }

    /**
     * Get a list of type of tour
     *
     * @param Request $request
     * @return mixed
     */
    public function getListType(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $query = $this->latest();
        
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($status)) {
            $query->where('status', '=', $status);
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
