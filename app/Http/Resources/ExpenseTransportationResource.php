<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseTransportationResource extends JsonResource
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
            'startPoint' => $this->startPoint,
            'endPoint' => $this->endPoint,
            'purpose' => $this->purpose,
            'transactionDate' => $this->transactionDate,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at' => $this->updated_at 
        ];
    }
}
