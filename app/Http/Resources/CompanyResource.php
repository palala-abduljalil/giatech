<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'fullName' => $this->fullName,
            'abbreviatedName' => $this->abbreviatedName,
            'motto' => $this->motto,
            'background' => $this->background,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'serviceDescription' => $this->serviceDescription,
            'freebieDescription' => $this->freebieDescription,
            'emailAddress' => $this->emailAddress,
            'websiteAddress' => $this->websiteAddress,
            'landlineNumber' => $this->landlineNumber,
            'mobileNumber' => $this->mobileNumber,
            'socialMediaAccounts' => CompanySocialLinksResource::collection($this->whenLoaded('socialMediaAccounts')),
            'stakeholders' => StakeholderResource::collection($this->whenLoaded('stakeholders')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'freebies' => FreebieResource::collection($this->whenLoaded('freebies')),
        ];
    }
}
