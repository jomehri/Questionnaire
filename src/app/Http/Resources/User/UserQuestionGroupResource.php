<?php

namespace App\Http\Resources\User;

use App\Models\Questions\UserQuestionGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class UserQuestionGroupResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            UserQuestionGroup::COLUMN_PAID_AMOUNT => $this->{UserQuestionGroup::COLUMN_PAID_AMOUNT},
            UserQuestionGroup::COLUMN_STATUS => $this->{UserQuestionGroup::COLUMN_STATUS},
            UserQuestionGroup::COLUMN_STARTED_AT => $this->getStartedAt()?->timestamp,
            UserQuestionGroup::COLUMN_BOUGHT_AT => $this->getBoughtAt()?->timestamp,
            UserQuestionGroup::COLUMN_COMPLETED_AT => $this->getCompletedAt()?->timestamp,
        ];
    }
}
