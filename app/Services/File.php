<?php

namespace App\Services;

class File {
    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getFile() : array {
        return [
            'fileName' => $this->fileName,
            'url' => $this->url
        ];
    }
}