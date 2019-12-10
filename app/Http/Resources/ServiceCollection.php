<?php

namespace App\Http\Resources;

use App\Http\Resources\ServiceOptionCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            // "image" => $this->images->first()->image ?? "",// for just the first image of the first serviceimage row
            // "images" => $this->images, // for an array of all images of this service
            'options' => ServiceOptionCollection::collection($this->options),
            // 'options' => ServiceOptionResource::collection($this->options),
        ];
    }
}
