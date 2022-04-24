<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            'causer' => new UserResource($this->whenLoaded('causer')),
            'activity' => $this->description,
            'dateAndTime' => Carbon::parse($this->created_at)->toDayDateTimeString()
        ];
    }
}
