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
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get the type that owns the tour.
     *
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
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
            'duration' => 'required|integer|between:1,127',
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
        $input = $request->only([
            'name',
            'destination_id',
            'type_id',
            'duration',
            'price',
            'overview',
            'status',
            'trending'
        ]);
        $input['slug'] = Str::slug($input['name']);
        $input = Utilities::clearAllXSS($input);

        if ($request->hasFile('image')) {
            $input['image'] = Utilities::storeImage($request, 'image', $this->pathTour);
        } else {
            $this->notification->setMessage('No image to upload', Notification::ERROR);
            return $this->notification;
        }

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
        $input = $request->only([
            'name',
            'destination_id',
            'type_id',
            'duration',
            'price',
            'overview',
            'status',
            'trending'
        ]);
        $input = Utilities::clearAllXSS($input);
        $input['slug'] = Str::slug($input['name']);

        // Upload Image
        if ($request->hasFile('image')) {
            $oldImage = $tour->image;
            $input['image'] = Utilities::storeImage($request, 'image', $this->pathTour);
            Storage::delete($this->pathTour . $oldImage);
        }

        $tour->fill($input);
        if ($tour->save()) {
            $this->notification->setMessage('Tour updated successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('Tour update failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Delete the tour by id in database.
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
            ->editColumn('name', function ($data) {
                $name = $data->name;
                $destination = $data->destination_name;
                $type = $data->type_name;
                $duration = Utilities::durationToString($data->duration);

                return view('admin.components.title_tour', compact(['name', 'destination', 'type', 'duration']));
            })
            ->editColumn('image', function ($data) {
                $pathImage = asset("storage/images/tours/" . $data->image);

                return view('admin.components.image', compact('pathImage'));
            })
            ->editColumn('price', function ($data) {
                return number_format($data->price, 2) . ' $';;
            })
            ->editColumn('status', function ($data) {
                return ($data->status == 1) ? 'Active' : 'Inactive';
            })
            ->editColumn('trending', function ($data) {
                return ($data->status == 1) ? 'Active' : 'Inactive';
            })
            ->addColumn('detail', function ($data) {
                $routerGallery = route('galleries.index', $data->id);
                $routerItinerary = route('itineraries.index', $data->id);
                $routerFAQ = route('faqs.index', $data->id);
                $routerReview = route('reviews.index', $data->id);
                $width = 90;

                $view = view('admin.components.button_link_info',
                    ['link' => $routerGallery, 'title' => 'Galleries', 'width' => $width])->render();

                $view .= view('admin.components.button_link_info',
                    ['link' => $routerItinerary, 'title' => 'Itineraries', 'width' => $width])->render();

                $view .= view('admin.components.button_link_info',
                    ['link' => $routerFAQ, 'title' => 'Faqs', 'width' => $width])->render();

                $view .= view('admin.components.button_link_info',
                    ['link' => $routerReview, 'title' => 'Reviews', 'width' => $width])->render();

                return $view;
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("tours.edit", $data->id);
                $linkDelete = route("tours.destroy", $data->id);

                return view('admin.components.action_link', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['name', 'image', 'status', 'detail', 'action'])
            ->make(true);
    }
}
