<?php

namespace App\Models\Questions\Scopes;

use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static QuestionGroup|Builder forQuestioner(int $questionerId)
 */
trait QuestionGroupScopeTrait
{

    /**
     * @param Builder $query
     * @param int $questionerId
     * @return void
     */
    public function scopeForQuestioner(Builder $query, int $questionerId): void
    {
        $query->where(QuestionGroup::COLUMN_QUESTIONER_ID, $questionerId);
    }

}
