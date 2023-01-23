<?php

namespace App\Models\Questions\Scopes;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Questions\UserQuestionGroup;

/**
 * @method static UserQuestionGroup|Builder bought()
 * @method static UserQuestionGroup|Builder started()
 * @method static UserQuestionGroup|Builder completed()
 * @method static UserQuestionGroup|Builder forUser(int $userId)
 * @method static UserQuestionGroup|Builder forQuestioner(int $questionerId)
 */
trait UserQuestionGroupScopeTrait
{

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeBought(Builder $query): void
    {
        $query->whereNotNull(UserQuestionGroup::COLUMN_BOUGHT_AT);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeStarted(Builder $query): void
    {
        $query->whereNotNull(UserQuestionGroup::STATUS_STARTED);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->whereNotNull(UserQuestionGroup::STATUS_COMPLETED);
    }

    /**
     * @param Builder $query
     * @param int $userId
     * @return void
     */
    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where(UserQuestionGroup::COLUMN_USER_ID, $userId);
    }

    /**
     * @param Builder $query
     * @param int $userId
     * @return void
     */
    public function scopeForQuestioner(Builder $query, int $questionerId): void
    {
        $query->where(UserQuestionGroup::COLUMN_QUESTIONER_ID, $questionerId);
    }
}
