<?php

namespace App\Models\Questions\Scopes;

use App\Models\Questions\Question;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder forQuestionGroup
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
}
