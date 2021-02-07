<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerListsResource extends JsonResource
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
            'id' => (int) $this->getId(),
            'full_name' => $this->getFullName(),
            'email' => $this->getEmail(),
            'country' => $this->getCountry(),
        ];
    }
}
