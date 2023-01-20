<?php

namespace App\Models\Questions\Scopes;

use App\Models\Questions\Question;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Question|Builder forQuestionGroup(int $questionGroupId)
 * @method static Question|Builder required()
 */
trait QuestionScopeTrait
{

    /**
     * @param Builder $query
     * @param int $questionGroupId
     * @return void
     */
    public function scopeForQuestionGroup(Builder $query, int $questionGroupId): void
    {
        $query->where(Question::COLUMN_QUESTION_GROUP_ID, $questionGroupId);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeRequired(Builder $query): void
    {
        $query->where(Question::COLUMN_IS_REQUIRED, true);
    }
}
