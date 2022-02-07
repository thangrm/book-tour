<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TourCollection extends ResourceCollection
{
    public static $wrap = 'tours';

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tours' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],

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
            'hello-collection-tour' => [
                'tour' => 'Collection Tour',
            ],
        ];
    }
}
