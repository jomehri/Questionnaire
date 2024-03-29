<?php

namespace App\Http\Resources\Questions;

use App\Models\Basic\User;
use App\Models\Questions\UserQuestionGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionerParticipantsResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var UserQuestionGroup $userQuestionGroup */
        $userQuestionGroup = $this;

        $user = $userQuestionGroup->getUser();

        return [
            'user' => [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
            ],
            'status' => [
                'value' => $userQuestionGroup->getStatus(),
                'translate' => __('questions/user_question_group.statuses.' . $userQuestionGroup->getStatus()),
            ],
            'completedAt' => $userQuestionGroup->getCompletedAt()?->timestamp,
        ];
    }
}
