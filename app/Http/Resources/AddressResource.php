<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullAddress' => $this->houseNumber. ' '.$this->streetName. ', '.$this->barangay.', '.$this->city.', '.$this->province.', '.$this->region,
            'houseNumber' => $this->houseNumber,
            'streetName' => $this->streetName,
            'barangay' => $this->barangay,
            'city' => $this->city,
            'province' => $this->province,
            'region' => $this->region
        ];  
    }
}
