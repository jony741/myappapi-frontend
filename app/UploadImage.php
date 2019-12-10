<?php


namespace App;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImage
{
    private $types = [
        'service' => 'service/',
        'provider' => 'providers/',
        'service_option' => 'service_option/',
    ];

    public function saveImage($body, $type = 'service')
    {
        if ($body) {
            // echo 'this:'.$this->id;
            $image = str_replace(' ', '+', $body);
            $imageName = $this->types[$type] . ($this->id ?? 'new'). '/' . Str::random(10) . '.jpg';
            // echo 'imageName:'.$imageName;
            $image = base64_decode($image);
            Storage::disk('public')->put($imageName, $image);
            // $imageName = 'storage' . $imageName;
        } else {
            $imageName = 'false';
        }

        // echo '/nimageName:'.$imageName;

        return $imageName;
    }

    public function checkAndDelete($image)
    {
        $image = str_replace('storage', '', $image);
        $exists = Storage::disk('public')->exists($image);
        if ($exists) {
            Storage::disk('public')->delete($image);
        }
        return $exists;
    }

    public function deleteDirectory($type = 'service')
    {
        Storage::disk('public')->deleteDirectory($this->types[$type] . $this->id);
    }

}
