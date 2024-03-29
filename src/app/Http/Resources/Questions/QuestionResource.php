<?php

namespace App\Http\Resources\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Question;
use App\Http\Resources\User\UserAnswerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
//        dd($this);
        return [
            BaseModel::COLUMN_ID => $this->{BaseModel::COLUMN_ID},
            Question::COLUMN_TITLE => $this->{Question::COLUMN_TITLE},
            Question::COLUMN_TYPE => $this->{Question::COLUMN_TYPE},
            Question::COLUMN_OPTIONS => $this->{Question::COLUMN_OPTIONS},
            Question::COLUMN_DESCRIPTION => $this->{Question::COLUMN_DESCRIPTION},
            Question::COLUMN_IS_REQUIRED => (bool)$this->{Question::COLUMN_IS_REQUIRED},
            'userAnswer' => UserAnswerResource::make($this->whenLoaded('userAnswer'))
        ];
    }
}
