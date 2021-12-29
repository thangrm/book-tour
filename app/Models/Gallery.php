<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'image'];
    protected $pathGallery = 'public/images/galleries/';
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for gallery
     *
     * @return string[]
     */
    public function rule()
    {
        return [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000'
        ];
    }

    /**
     * @param $tourId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getImagesByTourId($tourId)
    {
        return $this->where('tour_id', $tourId)->get();
    }

    /**
     * Store image for gallery
     *
     * @param Request $request
     * @return Notification
     */
    public function storeGallery(Request $request, $tourId)
    {
        $tour = Tour::find($tourId);
        if ($tour == null) {
            $this->notification->setMessage('Tour id not found', Notification::ERROR);
            return $this->notification;
        }

        if ($request->hasFile('image')) {
            $image = Utilities::storeImage($request, 'image', $this->pathGallery);
            $input = [
                'tour_id' => $tourId,
                'image' => $image
            ];

            if ($this->create($input)->exists) {
                $this->notification->setMessage('New image added successfully', Notification::SUCCESS);
            } else {
                $this->notification->setMessage('Image addition failed', Notification::ERROR);
            }
        } else {
            $this->notification->setMessage('No file to upload', Notification::ERROR);
        }

        return $this->notification;
    }
}
