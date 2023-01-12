<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\Question;
use App\Models\Questions\Questioner;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait QuestionGroupRelationTrait
{

    /**
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
