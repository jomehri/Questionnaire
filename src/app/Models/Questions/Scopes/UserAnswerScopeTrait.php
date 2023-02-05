<?php

namespace App\Models\Questions\Scopes;

use App\Models\Questions\Question;
use App\Models\Questions\QuestionGroup;
use App\Models\Questions\UserAnswer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static UserAnswer|Builder forUser(int $userId)
 * @method static UserAnswer|Builder forQuestion(int $questionId)
 * @method static UserAnswer|Builder forQuestioner(int $questionerId)
 */
trait UserAnswerScopeTrait
{

    /**
     * @param Builder $query
     * @param int $userId
     * @return void
     */
    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where(UserAnswer::COLUMN_USER_ID, $userId);
    }

    /**
     * @param Builder $query
     * @param int $userId
     * @return void
     */
    public function scopeForQuestion(Builder $query, int $questionId): void
    {
        $query->where(UserAnswer::COLUMN_QUESTION_ID, $questionId);
    }

    /**
     * @param Builder $query
     * @param int $questionerId
     * @return void
     */
    public function scopeForQuestioner(Builder $query, int $questionerId): void
    {
        $questionIds = Question::forQuestioner($questionerId)->pluck('id');
        $query->whereIn(UserAnswer::COLUMN_QUESTION_ID, $questionIds);
    }
}
