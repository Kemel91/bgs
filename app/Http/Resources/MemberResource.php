<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MemberResource
 * @package App\Http\Resources
 */
class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getResource()->id,
            'firstname' => $this->getResource()->firstname,
            'lastname' => $this->getResource()->lastname,
            'email' => $this->getResource()->email,
            'events' => EventResource::collection($this->getResource()->events)
        ];
    }

    /**
     * @return \App\Member
     */
    private function getResource(): \App\Member
    {
        return $this->resource;
    }
}
