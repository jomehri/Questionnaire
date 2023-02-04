<?php

namespace App\Models\Questions\Relations;

use App\Models\BaseModel;
use App\Models\Questions\Questioner;
use App\Models\Questions\QuestionGroup;
use App\Models\Questions\UserQuestionGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $questionGroups
 * @property ?UserQuestionGroup $userQuestionGroup
 */
trait QuestionerRelationTrait
{

    /**
     * @return HasMany
     */
    public function questionGroups(): HasMany
    {
        return $this->hasMany(QuestionGroup::class);
    }

    /**
     * @return HasMany
     */
    public function userQuestionGroups(): HasMany
    {
        return $this->hasMany(UserQuestionGroup::class);
    }
}
