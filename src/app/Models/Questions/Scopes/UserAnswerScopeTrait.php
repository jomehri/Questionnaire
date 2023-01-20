<?php

namespace App\Models\Questions\Scopes;

use App\Models\Questions\UserAnswer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static UserAnswer|Builder forUser(int $userId)
 * @method static UserAnswer|Builder forQuestion(int $questionId)
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
}
