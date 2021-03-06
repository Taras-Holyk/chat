<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\MongoElastiquentTrait;

class Chat extends Model
{
    use MongoElastiquentTrait;

    protected $fillable = [
        'users'
    ];

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'chat_id', '_id');
    }
}
