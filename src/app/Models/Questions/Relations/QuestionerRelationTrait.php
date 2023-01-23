<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $questionGroups
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
}
