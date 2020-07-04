<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EventResource
 * @package App\Http\Resources
 */
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getResource()->id,
            'title' => $this->getResource()->title,
            'city' => $this->getResource()->city
        ];
    }

    /**
     * @return \App\Event
     */
    private function getResource(): \App\Event
    {
        return $this->resource;
    }
}
