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
    protected $path = 'public/images/tours/';

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
     * Get the itineraries for the tour.
     *
     */
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    /**
     * Get the galleries for the tour.
     *
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Get the FAQs for the tour.
     *
     */

    public function faqs()
    {
        return $this->hasMany(FAQ::class);
    }

    /**
     * Get the reviews for the tour.
     *
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Validate rules for tour
     *
     * @param $id
     * @return string[]
     */
    public function rules($id = null)
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
            'panoramic_image' => 'max:255',
            'video' => 'max:100',
        ];

        if ($id != null) {
            $rule['name'] = 'max:50|string|unique:tours,name,' . $id;
            $rule['image'] = 'image|mimes:jpeg,jpg,png,gif|max:5000';
            $rule['destination_id'] = 'exists:destinations,id';
            $rule['type_id'] = 'exists:tour_types,id';
            $rule['duration'] = 'integer|between:1,127';
            $rule['price'] = 'numeric|min:0';
            $rule['status'] = 'integer|between:1,2';
            $rule['trending'] = 'integer|between:1,2';
        }

        return $rule;
    }

    /**
     * Store a new tour in database.
     *
     * @param Request $request
     * @param int $id
     * @return integer
     */
    public function saveTour(Request $request, int $id = 0)
    {
        $input = $request->all();
        $input = Utilities::clearAllXSS($input);

        $tour = $this->findOrNew($id);
        $tour->slug = Str::slug($tour->name);
        $oldImage = $tour->image;

        if ($request->hasFile('image')) {
            $input['image'] = Utilities::storeImage($request, 'image', $this->path);
        }

        $duration = empty($request->duration) ? 128 : $request->duration;   //128 is max for duration
        if ($duration < $tour->itineraries()->count()) {
            return 2;
        }

        $tour->fill($input);
        if ($tour->save()) {
            if ($request->hasFile('image')) {
                Storage::delete($this->path . $oldImage);
            }
        } else {
            Storage::delete($this->path . $tour->image);
        }

        return 1;
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
        Storage::delete($this->path . $image);

        foreach ($tour->galleries as $gallery) {
            Storage::delete('public/images/galleries/' . $gallery->image);
        }

        $tour->galleries()->delete();
        $tour->itineraries()->delete();
        $tour->faqs()->delete();
        $tour->reviews()->delete();

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
            $search = Utilities::clearXSS($search);
            $query->where(function ($query) use ($search) {
                $query->where('tours.name', 'like', '%' . $search . '%');
                $query->orwhere('tours.slug', 'like', '%' . $search . '%');
            });
        }

        if (!empty($destinationId)) {
            $query->where('tours.destination_id', $destinationId);
        }

        if (!empty($typeId)) {
            $query->where('tours.type_id', $typeId);
        }

        if (!empty($status)) {
            $query->where('tours.status', $status);
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
                $link = route('tours.update', $data->id);
                $class = 'btn-switch-status';

                return view('admin.components.button_switch',
                    ['status' => $data->status, 'link' => $link, 'class' => $class,]);
            })
            ->editColumn('trending', function ($data) {
                $link = route('tours.update', $data->id);
                $class = 'btn-switch-trending';

                return view('admin.components.button_switch',
                    ['status' => $data->trending, 'link' => $link, 'class' => $class,]);
            })
            ->addColumn('detail', function ($data) {
                $routerInfo = route('tours.info', $data->id);
                $routerGallery = route('galleries.index', $data->id);
                $routerItinerary = route('itineraries.index', $data->id);
                $routerFAQ = route('faqs.index', $data->id);
                $routerReview = route('reviews.index', $data->id);
                $width = 90;

                $view = view('admin.components.button_link_info',
                    ['link' => $routerInfo, 'title' => 'Info', 'width' => $width])->render();

                $view .= view('admin.components.button_link_info',
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
