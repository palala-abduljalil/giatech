<?php

namespace App\Services\Content\Service;

use App\Models\Service;

class StoreService 
{
    public function __construct(array $request)
    {
        $this->data = array (
            'title' => $request['title'],
            'description' => $request['description'],
            'created_by' => auth()->user()->employee_id,
        );
        if (array_key_exists('image', $request)) {
            $this->coverImage = $request['image'];
        } else {
            $this->coverImage = 'images/default-placeholder.png';
        }
    }

    public function store(): void {
        $this->service = Service::create($this->data);
        $this->addCoverImage();
    }

    private function addCoverImage(): void {
        $this->service->addMedia($this->coverImage)
        ->preservingOriginal()->toMediaCollection('service_cover');
    }
}