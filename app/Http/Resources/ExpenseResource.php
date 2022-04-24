<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'particular' => $this->particular,
            'amount' => $this->amount,
            'transactionDate' => Carbon::parse($this->created_at)->toFormattedDateString(),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'category' => new ExpenseCategoryResource($this->whenLoaded('category')),
            'attachments' => ExpenseAttachmentResource::collection($this->whenLoaded('attachments')),
            'createdBy' => new EmployeeResource($this->whenLoaded('createdBy')),
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at' => $this->updated_at 
        ];
    }
}
