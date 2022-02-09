<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'image_seo' => $this->image_seo,
            'meta_description' => $this->meta_description,
            'meta_title' => $this->meta_title,
            'video' => $this->video,
            'map' => $this->map,
            'price' => $this->price,
            'panoramic_image' => $this->panoramic_image,
            'overview' => $this->overview,
            'included' => $this->included,
            'addition' => $this->addition,
            'departure' => $this->departure,
            'duration' => $this->duration,
            'status' => $this->status,
            'trending' => $this->trending,
            'destination' => $this->destination->name,
            'type' => $this->type->name,
            'itineraries' => ItineraryResource::collection($this->whenLoaded('itineraries')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
