<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\UserAnswer;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property QuestionGroup $questionGroup
 * @property Collection $userAnswers
 * @property ?UserAnswer $userAnswer
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

    /**
     * @return HasOne
     */
    public function userAnswer(): HasOne
    {
        return $this->hasOne(UserAnswer::class);
    }
}
