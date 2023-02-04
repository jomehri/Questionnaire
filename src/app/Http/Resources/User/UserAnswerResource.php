<?php

namespace App\Http\Resources\User;

use App\Models\BaseModel;
use App\Models\Basic\User;
use App\Models\Questions\UserAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            UserAnswer::COLUMN_ANSWER => $this->{UserAnswer::COLUMN_ANSWER},
            Model::CREATED_AT => $this->{Model::CREATED_AT}?->timestamp,
        ];
    }
}
