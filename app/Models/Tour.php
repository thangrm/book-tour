<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Tour extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $notification;
    protected $pathTour = 'public/images/tours/';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

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
     * Validate rules for tour
     *
     * @param $id
     * @return string[]
     */
    public function rule($id = null)
    {
        $rule = [
            'name' => 'required|max:50|string|unique:tours',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
            'destination_id' => 'required|exists:destinations,id',
            'type_id' => 'required|exists:tour_types,id',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|integer|between:1,2',
            'trending' => 'required|integer|between:1,2',
        ];

        if ($id != null) {
            $rule['name'] = 'required|max:50|string|unique:tours,name,' . $id;
            $rule['image'] = 'image|mimes:jpeg,jpg,png,gif|max:5000';
        }

        return $rule;
    }

    /**
     * Store a new tour in database.
     *
     * @param Request $request
     * @return Notification
     */
    public function storeTour(Request $request)
    {
        $input = $request->only('name', 'destination_id', 'type_id', 'duration', 'price', 'status', 'trending');
        $input = Utilities::clearAllXSS($input);
        $input['image'] = Utilities::storeImage($request, 'image', $this->pathTour);
        $input['slug'] = Str::slug($input['name']);

        if ($this->create($input)->exists) {
            $this->notification->setMessage('New tour added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Tour creation failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Update tour in database.
     *
     * @param Request $request
     * @param $id
     * @return Notification
     */
    public function updateTour(Request $request, $id)
    {
        $tour = $this->findOrFail($id);
        $input = $request->only('name', 'destination_id', 'type_id', 'duration', 'price', 'status', 'trending');
        $input = Utilities::clearAllXSS($input);
        $input['slug'] = Str::slug($input['name']);
        $tour->fill($input);

        // Upload Image
        if ($request->hasFile('image')) {
            $oldImage = $tour->image;
            $image = Utilities::storeImage($request, 'image', $this->pathTour);
            Storage::delete($this->pathTour . $oldImage);
            $tour->image = $image;
        }

        if ($tour->save()) {
            $this->notification->setMessage('Tour updated successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Tour update failed', Notification::ERROR);
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
        $tour = $this->findOrFail($id);
        $image = $tour->image;
        Storage::delete($this->pathTour . $image);

        return $tour->delete();
    }

    /**
     * Get a list of tours
     *
     * @param Request $request
     * @return mixed
     */
    public function getListTours(Request $request)
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
    public function getDataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                $durationString = Utilities::durationToString($data->duration);
                return "<b>$data->name </b> <br>
                        $data->destination_name  ($data->type_name)<br>
                        <span style='font-size: smaller; color: #636567'> $durationString </span>";
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
                $routerGallery = route('galleries.index', $data->id);
                $routerItinerary = route('itineraries.index', $data->id);
                $routerFAQ = route('faqs.index', $data->id);
                return '<a class="btn btn-info text-white mt-1" style="width: 80px">Info</a>
                        <a href="' . $routerGallery . '" class="btn btn-info text-white mt-1" style="width: 80px">Gallery</a>
                        <a href="' . $routerItinerary . '" class="btn btn-info text-white mt-1" style="width: 80px">Itineraries</a>
                        <a href="' . $routerFAQ . '"class="btn btn-info text-white mt-1" style="width: 80px">Faqs</a>
                        <a class="btn btn-info text-white mt-1" style="width: 80px">Review</a>
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
