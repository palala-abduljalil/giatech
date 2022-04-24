<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'isRenewed' => $this->isRenewed,
            'isActivated' => $this->isActivated,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'role' => new RoleResource($this->whenLoaded('role')),
            'status' => new UserStatusResource($this->whenLoaded('status')),
            'modules' => SystemModuleResource::collection($this->whenLoaded('modules')),
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
