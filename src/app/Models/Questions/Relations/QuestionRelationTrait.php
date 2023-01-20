<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\UserAnswer;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property QuestionGroup $questionGroup
 * @property Collection $userAnswers
 */
trait QuestionRelationTrait
{

    /**
     * @return BelongsTo
     */
    public function questionGroup(): BelongsTo
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    /**
     * @return HasMany
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}
