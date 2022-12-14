<?php

namespace App\Http\Resources\User;

use App\Models\Basic\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            User::COLUMN_FIRST_NAME => $this->{User::COLUMN_FIRST_NAME},
            User::COLUMN_LAST_NAME => $this->{User::COLUMN_LAST_NAME},
            User::COLUMN_MOBILE => $this->{User::COLUMN_MOBILE},
        ];
    }
}
