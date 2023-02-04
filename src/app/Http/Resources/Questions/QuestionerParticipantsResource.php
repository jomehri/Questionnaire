<?php

namespace App\Http\Resources\Questions;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionerParticipantsResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'ehem' => 5000,
        ];
    }
}
