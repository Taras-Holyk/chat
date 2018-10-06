<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Message;
use App\Models\Message as MessageModel;

class Messages extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (MessageModel $message) {
            return (new Message($message));
        });

        return parent::toArray($request);
    }
}
