<?php

namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ClientOrganizationResource;
use App\Http\Resources\ClientContactNumberResource;

class ClientResource extends JsonResource
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
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'middleInitial' => strtoupper($this->middleName[0]). '. ',
            'lastName' => $this->lastName,
            'suffix' => $this->suffix,
            'fullName' => $this->firstName .' '.$this->middleName. ' '. $this->lastName. ' '. $this->suffix,
            'name' => $this->firstName.' '.strtoupper($this->middleName[0]). '. '.$this->lastName. ' '. $this->suffix,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'address' => new AddressResource($this->whenLoaded('address')),
            'contactNumber' => new ClientContactNumberResource($this->whenLoaded('contactNumber')),
            'emailAddress' => new ClientEmailAddressResource($this->whenLoaded('emailAddress')),
            'organization' => new ClientOrganizationResource($this->whenLoaded('organization')),
            'profilePicture' => new ProfilePictureResource($this->whenLoaded('profilePicture')),
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
        ];
    }
}
