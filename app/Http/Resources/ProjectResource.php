<?php

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'name' => $this->title,
            'description' => $this->description,
            'client' => new ClientResource($this->whenLoaded('client')),
            'status' => new ProjectStatusResource($this->whenLoaded('status')),
            'category' => new ProjectCategoryResource($this->whenLoaded('category')),
            'activities' => ProjectActivityResource::collection($this->whenLoaded('activities')),
            'attachments' => ProjectAttachmentResource::collection($this->whenLoaded('attachments')),
            'totalContractPrice' => $this->totalContractPrice,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
        ];
    }
}
