<?php

namespace App\Http\Resources\Questions;

use App\Models\BaseModel;
use App\Models\Questions\QuestionGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionGroupResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            BaseModel::COLUMN_ID => $this->{BaseModel::COLUMN_ID},
            QuestionGroup::COLUMN_TITLE => $this->{QuestionGroup::COLUMN_TITLE},
            'questioners' => QuestionerResource::collection($this->questioners)
        ];
    }
}
