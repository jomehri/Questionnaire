<?php

namespace App\Models\Questions\Scopes;

use App\Models\Questions\Question;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Question|Builder forQuestioner(int $questionerId)
 * @method static Question|Builder forQuestionGroup(int $questionGroupId)
 * @method static Question|Builder required()
 */
trait QuestionScopeTrait
{

    /**
     * @param Builder $query
     * @param int $questionerId
     * @return void
     */
    public function scopeForQuestioner(Builder $query, int $questionerId): void
    {
        $questionGroupIds = QuestionGroup::forQuestioner($questionerId)->pluck('id');
        $query->whereIn(Question::COLUMN_QUESTION_GROUP_ID, $questionGroupIds);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeRequired(Builder $query): void
    {
        $query->where(Question::COLUMN_IS_REQUIRED, true);
    }

    /**
     * @param Builder $query
     * @param $questionGroupIds
     * @return void
     */
    public function scopeForQuestionGroup(Builder $query, $questionGroupId): void
    {
        $query->where(Question::COLUMN_QUESTION_GROUP_ID, $questionGroupId);
    }
}
