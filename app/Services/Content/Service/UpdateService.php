<?php

namespace App\Services\Content\Service;

use App\Models\Service;

class UpdateService 
{
    public function __construct(array $request, Service $service)
    {
        $this->data = array (
            'title' => $request['title'],
            'description' => $request['description'],
        );
        $this->service = $service;
        if (array_key_exists('image', $request)) {
            $this->coverImage = $request['image'];
        }
    }

    public function update(): void {
        $this->service->update($this->data);
        if (isset($this->coverImage)) {
            $this->addCoverImage();
        }
    }

    private function addCoverImage(): void {
        $this->service->addMedia($this->coverImage)
        ->preservingOriginal()->toMediaCollection('service_cover');
    }
}