<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Traits\GetListData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Type extends Model
{
    use HasFactory, GetListData;

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
    public function rules($id = null): array
    {
        $rule = [
            'name' => 'required|max:50|string|unique:tour_types',
            'status' => 'required|integer|between:1,2'
        ];

        if ($id != null) {
            $rule['name'] = "max:50|string|unique:tour_types,name,$id";
            $rule['status'] = 'integer|between:1,2';
        }

        return $rule;
    }

    /**
     * Save data type in database.
     *
     * @param Request $request
     * @param int $id
     */
    public function saveData(Request $request, int $id = 0)
    {
        $input = $request->only('name', 'status');
        $input = Utilities::clearAllXSS($input);
        $type = $this->findOrNew($id);

        $type->fill($input);
        $type->save();
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
            return 2;
        }
        $type->delete();

        return 1;
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
            ->setRowId(function ($data) {
                return 'type-' . $data->id;
            })
            ->editColumn('status', function ($data) {
                $link = route('types.update', $data->id);
                return view('components.button_switch', ['status' => $data->status, 'link' => $link]);
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("types.update", $data->id);
                $linkDelete = route("types.destroy", $data->id);

                return view('components.action_modal', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
