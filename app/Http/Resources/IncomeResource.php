<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
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
            'project' => new ProjectResource($this->whenLoaded('project')),
            'service' => $this->service,
            'amount' => $this->amount,
            'transactionDate' => Carbon::parse($this->transactionDate)->toFormattedDateString(),
            'category' => new IncomeCategoryResource($this->whenLoaded('category')),
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at' => $this->updated_at
        ];
    }
}
