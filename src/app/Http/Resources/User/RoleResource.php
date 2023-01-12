<?php

namespace App\Http\Resources\User;

use App\Models\Basic\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ];
    }
}
