<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * @param $tourId
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

    /**
     * Delete the image by id in galleries.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $gallery = $this->findOrFail($id);
        Storage::delete($this->pathGallery . $gallery->image);
        return $gallery->delete();
    }
}
