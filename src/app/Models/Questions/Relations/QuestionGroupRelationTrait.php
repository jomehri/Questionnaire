<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\Question;
use App\Models\Questions\Questioner;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Questioner $questioner
 */
trait QuestionGroupRelationTrait
{

    /**
     * @deprecate @aliJo
     * @return BelongsTo
     */
    public function questioner(): BelongsTo
    {
        return $this->belongsTo(Questioner::class);
    }

    /**
     * @return HasOne
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
