<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientProjectResource extends JsonResource
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
            'status' => new ProjectStatusResource($this->whenLoaded('status')),
            'category' => new ProjectCategoryResource($this->whenLoaded('category')),
            'activities' => ProjectActivityResource::collection($this->whenLoaded('activities')),
            'attachments' => ProjectAttachmentResource::collection($this->whenLoaded('attachments')),
            'totalContractPrice' => $this->totalContractPrice,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ];
    }
}
