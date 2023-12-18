<?php

namespace App\Http\Resources;

use App\Models\Properties;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertiesResource extends JsonResource
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
            'ID' => $this->id,
            'name' => $this->name,
            'about' => $this->about,
            'rentLow' => $this->rent_low,
            'rentHigh' => $this->rent_high,
            'bedroomLow' => $this->bedroom_low,
            'bedroomHigh' => $this->bedroom_high,
            'zip' => $this->zip,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'street' => $this->street->name,
            'city' => $this->city->name,
            'state' => $this->state->name,
            'phoneNumber' => $this->phone_number,
            'website' => $this->website,
            'stars' => $this->stars,
            'images' => GalleriesResource::collection($this->whenLoaded('galleries')),
        ];
    }
}
