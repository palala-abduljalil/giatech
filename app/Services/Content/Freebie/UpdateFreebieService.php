<?php

namespace App\Services\Content\Freebie;

use App\Models\Freebie;

class UpdateFreebieService
{
    public function __construct(array $request, Freebie $freebie)
    {
        $this->freebie = $freebie;
        $this->data = array(
            'name' => $request['name'],
        );
        if (array_key_exists('image', $request)) {
            $this->coverImage = $request['image'];
        }
    }

    public function update(): void
    {
        $this->freebie->update($this->data);
        if (isset($this->coverImage)) {
            $this->addCoverImage();
        }
    }

    private function addCoverImage(): void
    {
        $this->freebie->addMedia($this->coverImage)
            ->preservingOriginal()->toMediaCollection('freebie_cover');
    }
}
