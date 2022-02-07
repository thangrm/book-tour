<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public static $wrap = 'tour';

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
            'itineraries' => ItineraryResource::collection($this->whenLoaded('itineraries')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'hello-tour' => [
                'tour' => 'TourDuLich',
            ],
        ];
    }
}
