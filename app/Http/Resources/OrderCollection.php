<?php

namespace App\Http\Resources;

use App\Http\Resources\EventResource;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\ServiceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
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
            "status" => $this->status,
            "description" => $this->description,
            'event' => new EventResource($this->event),
            'provider' => new ProviderResource($this->provider),
            'services' => ServiceCollection::collection($this->services),
        ];
    }
}
