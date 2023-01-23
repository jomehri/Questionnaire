<?php

namespace App\Http\Resources\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Questioner;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionerWithoutQuestionGroupResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            BaseModel::COLUMN_ID => $this->{BaseModel::COLUMN_ID},
            Questioner::COLUMN_TITLE => $this->{Questioner::COLUMN_TITLE},
            Questioner::COLUMN_SLUG => $this->{Questioner::COLUMN_SLUG},
            Questioner::COLUMN_PRICE => $this->{Questioner::COLUMN_PRICE},
        ];
    }
}
