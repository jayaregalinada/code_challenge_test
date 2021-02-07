<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'full_name' => $this->getFullName(),
            'email' => $this->getEmail(),
            'username' => $this->getUsername(),
            'gender' => $this->getGender() === 1 ? 'female' : 'male',
            'country' => $this->getCountry(),
            'city' => $this->getCity(),
            'phone' => $this->getPhone(),
        ];
    }
}
