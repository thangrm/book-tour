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
    protected $path = 'public/images/galleries/';
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
    public function rules()
    {
        return [
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000'
        ];
    }

    /**
     * @param $tourId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getImages($tourId)
    {
        return $this->where('tour_id', $tourId)->get();
    }

    /**
     * Store image for gallery
     *
     * @param Request $request
     * @param $tourId
     */
    public function storeGallery(Request $request, $tourId)
    {
        Tour::findOrFail($tourId);

        $images = $request->file('images');
        $files = Utilities::storeMultiImage($images, $this->path);
        $data = [];

        foreach ($files as $file) {
            $input = [
                'tour_id' => $tourId,
                'image' => $file,
            ];
            $data[] = $input;
        }

        self::insert($data);
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
        Storage::delete($this->path . $gallery->image);
        return $gallery->delete();
    }
}
