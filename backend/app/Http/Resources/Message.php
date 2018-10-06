<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$request->all()) {
            return parent::toArray($request);
        }

        return [
            'id' => $this->id,
            'text' => $this->text,
            'user' => new User($this->user)
        ];
    }
}
