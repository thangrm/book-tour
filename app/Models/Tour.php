<?php

namespace App\Models;

use App\Libraries\Utilities;
use App\Traits\GetListData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Tour extends Model
{
    use HasFactory, GetListData;

    protected $guarded = [];
    protected $path = 'public/images/tours/';

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
        return $this->hasMany(Itinerary::class)->oldest();
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
     * Get the bookings for the tour.
     *
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the bookings for the tour.
     *
     */
    public function rooms()
    {
        return $this->hasMany(Room::class)->orderBy('price', 'desc');
    }

    /**
     * Get the FAQs for the tour.
     *
     * @param bool $filterActive
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs($filterActive = false)
    {
        $query = $this->hasMany(FAQ::class);
        if ($filterActive) {
            $query->where('status', 1);
        }

        return $query;
    }

    /**
     * Get the reviews for the tour.
     *
     * @param bool $filterActive
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews($filterActive = false)
    {
        $query = $this->hasMany(Review::class);
        if ($filterActive) {
            $query->where('status', 1)->latest();
        }

        return $query;
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
            'name' => 'required|max:255|string|unique:tours',
            'slug' => 'required|max:255|string|unique:tours',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
            'destination_id' => 'required|exists:destinations,id',
            'type_id' => 'required|exists:tour_types,id',
            'duration' => 'required|integer|between:1,127',
            'price' => 'required|numeric|min:0',
            'status' => 'required|integer|between:1,2',
            'trending' => 'required|integer|between:1,2',
            'image_seo' => 'image|mimes:jpeg,jpg,png,gif|max:5000',
            'meta_title' => 'max:70',
            'meta_description' => 'max:150',
            'panoramic_image' => 'max:255',
            'video' => 'max:100',
        ];

        if ($id != null) {
            $rule['name'] = 'max:255|string|unique:tours,name,' . $id;
            $rule['slug'] = 'max:255|string|unique:tours,slug,' . $id;
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
     * Get a tour by slug
     *
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getTourBySlug($slug)
    {
        return $this->with('destination', 'type', 'itineraries.places', 'rooms')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
    }

    /**
     * Get list tour active
     *
     * @return mixed
     */
    public function getByTrending(int $trending = 1, int $limit = 0)
    {
        $query = $this->with('type', 'destination')
            ->where('status', 1)
            ->where('trending', $trending)
            ->latest();

        if ($limit != 0) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get list tour related
     *
     * @param $tour
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRelated($tour)
    {
        return $this->with('destination', 'type')
            ->where('status', 1)
            ->where('destination_id', $tour->destination_id)
            ->where('id', '!=', $tour->id)
            ->limit(6)
            ->get();
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
        $input = Utilities::clearAllXSS($input, ['map', 'overview', 'included', 'additional', 'departure']);

        $tour = $this->findOrNew($id);
        $oldImage = $tour->image;
        $oldImageSeo = $tour->image_seo;

        if ($request->hasFile('image')) {
            $input['image'] = Utilities::storeImage($request->file('image'), $this->path);
        }

        if ($request->hasFile('image_seo')) {
            $input['image_seo'] = Utilities::storeImage($request->file('image_seo'), $this->path);
        }

        $duration = empty($request->duration) ? 128 : $request->duration;   //128 is max for duration
        if ($duration < $tour->itineraries()->count()) {
            return 2;
        }

        $tour->fill($input);
        $tour->slug = Str::slug($tour->slug);
        if ($tour->save()) {
            if ($request->hasFile('image')) {
                Storage::delete($this->path . $oldImage);
            }

            if ($request->hasFile('image')) {
                Storage::delete($this->path . $oldImageSeo);
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
        if ($tour->bookings()->count() > 0) {
            return 2;
        }

        DB::transaction(function () use ($tour) {
            $tour->galleries()->delete();
            $tour->itineraries()->delete();
            $tour->faqs()->delete();
            $tour->reviews()->delete();
            $tour->delete();

            Storage::delete($this->path . $tour->image);
            Storage::delete($this->path . $tour->image_seo);
            foreach ($tour->galleries as $gallery) {
                Storage::delete('public/images/galleries/' . $gallery->image);
            }
        });

        return 1;
    }

    public function getListForApi(Request $request)
    {
        $perPage = $request->per_page ?? 8;
        $search = $request->search;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $duration = $request->duration;
        $status = $request->status;

        $query = Tour::with('itineraries.places', 'destination', 'type');

        if (!empty($search)) {
            $search = Utilities::clearXSS($search);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orwhere('slug', 'like', '%' . $search . '%');
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        if (!empty($duration)) {
            $query->where('duration', $duration);
        }

        return $query->paginate($perPage);
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

                return view('components.title_tour', compact(['name', 'destination', 'type', 'duration']));
            })
            ->editColumn('image', function ($data) {
                $pathImage = asset("storage/images/tours/" . $data->image);

                return view('components.image', compact('pathImage'));
            })
            ->editColumn('price', function ($data) {
                return number_format($data->price) . ' đ';;
            })
            ->editColumn('status', function ($data) {
                $link = route('tours.update', $data->id);
                $class = 'btn-switch-status';

                return view('components.button_switch',
                    ['status' => $data->status, 'link' => $link, 'class' => $class,]);
            })
            ->editColumn('trending', function ($data) {
                $link = route('tours.update', $data->id);
                $class = 'btn-switch-trending';

                return view('components.button_switch',
                    ['status' => $data->trending, 'link' => $link, 'class' => $class,]);
            })
            ->addColumn('detail', function ($data) {
                $routerInfo = route('tours.info', $data->id);
                $routerGallery = route('galleries.index', $data->id);
                $routerItinerary = route('itineraries.index', $data->id);
                $routerFAQ = route('faqs.index', $data->id);
                $routerReview = route('reviews.index', $data->id);
                $routerRoom = route('rooms.index', $data->id);
                $width = 69;

                $view = view('components.action',
                    ['link' => $routerInfo, 'title' => 'Thông tin', 'width' => $width])->render();

                $view .= view('components.action',
                    ['link' => $routerGallery, 'title' => 'Ảnh', 'width' => $width])->render();

                $view .= view('components.action',
                    ['link' => $routerItinerary, 'title' => 'Hành trình', 'width' => $width])->render();

                $view .= view('components.action',
                    ['link' => $routerRoom, 'title' => 'Phòng', 'width' => $width])->render();

                $view .= view('components.action',
                    ['link' => $routerReview, 'title' => 'Đánh giá', 'width' => $width])->render();

                $view .= view('components.action',
                    ['link' => $routerFAQ, 'title' => 'Hỏi đáp', 'width' => $width])->render();

                return $view;
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("tours.edit", $data->id);
                $linkDelete = route("tours.destroy", $data->id);

                return view('components.action_link', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['name', 'image', 'status', 'detail', 'action'])
            ->make(true);
    }
}
