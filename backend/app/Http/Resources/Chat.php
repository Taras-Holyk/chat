<?php

namespace App\Http\Resources;

use App\Contracts\Repositories\UsersRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class Chat extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->resource) {
            return parent::toArray($request);
        }

        $usersRepository = app(UsersRepositoryInterface::class);
        foreach ($this->users as $userId) {
            if ($userId != auth()->id()) {
                $user = $usersRepository->getById($userId);
                break;
            }
        }

        return [
            'id' => $this->id,
            'user' => new User($user),
            'last_message' => new Message($this->resource->messages()->orderBy('created_at', 'DESC')->first())
        ];
    }
}
