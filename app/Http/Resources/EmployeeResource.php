<?php

namespace App\Http\Resources;

use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'employeeNumber' => $this->employeeNumber,
            'account' => new AccountResource($this->whenLoaded('account')),
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'middleInitial' => strtoupper($this->middleName[0]). '. ',
            'lastName' => $this->lastName,
            'fullName' => $this->firstName .' '.$this->middleName. ' '. $this->lastName. ' '. $this->suffix,
            'name' => $this->firstName.' '.strtoupper($this->middleName[0]). '. '.$this->lastName. ' '. $this->suffix,
            'suffix' => $this->suffix,
            'address' => new AddressResource($this->whenLoaded('address')),
            'contactNumber' => new EmployeeContactNumberResource($this->whenLoaded('contactNumber')),
            'emailAddress' => new EmployeeEmailAddressResource($this->whenLoaded('emailAddress')),
            'dateHired' => Carbon::createFromFormat('Y-m-d', $this->dateHired)->format('F d, Y'),
            'position' => new PositionResource($this->whenLoaded('position')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'status' => new StatusResource($this->whenLoaded('status')),
            'school' => new SchoolResource($this->whenLoaded('school')),
            'degree' => new DegreeResource($this->whenLoaded('degree')),
            'yearGraduated' => $this->yearGraduated,
            'achievements' => AchievementResource::collection($this->whenLoaded('achievements')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'profilePicture' => new ProfilePictureResource($this->whenLoaded('profilePicture')),
            'attachments' => EmployeeAttachmentResource::collection($this->whenLoaded('attachments')),
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
