<?php

namespace App\Services\Content\Freebie;

use App\Models\Freebie;

class StoreFreebieService
{
    public function __construct(array $request)
    {
        $this->data = array(
            'name' => $request['name'],
            'created_by' => auth()->user()->employee_id,
        );

        if (array_key_exists('image', $request)) {
            $this->coverImage = $request['image'];
        } else {
            $this->coverImage = 'images/default-placeholder.png';
        }
    }

    public function store(): void
    {
        $this->freebie = Freebie::create($this->data);
        $this->addCoverImage();
    }

    private function addCoverImage(): void
    {
        $this->freebie->addMedia($this->coverImage)
            ->preservingOriginal()->toMediaCollection('freebie_cover');
    }
}
