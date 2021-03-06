<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\MongoElastiquentTrait;

class Message extends Model
{
    use MongoElastiquentTrait;

    protected $fillable = [
        'chat_id', 'user_id', 'text'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', '_id');
    }

    public function chat()
    {
        return $this->belongsTo('App\Models\Chat', 'chat_id', '_id');
    }
}
