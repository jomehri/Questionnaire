<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\Question;
use App\Models\Questions\Questioner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection $questioners
 */
trait QuestionGroupRelationTrait
{

    /**
     * @deprecate @aliJo
     * @return BelongsToMany
     */
    public function questioners(): BelongsToMany
    {
        return $this->belongsToMany(Questioner::class, 'questioner_question_group');
    }

    /**
     * @return HasOne
     */
    public function questions(): HasOne
    {
        return $this->hasOne(Question::class);
    }
}
