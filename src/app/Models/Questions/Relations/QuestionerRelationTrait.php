<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait QuestionerRelationTrait
{

    /**
     * @return BelongsToMany
     */
    public function questionGroups(): BelongsToMany
    {
        return $this->belongsToMany(QuestionGroup::class, 'questioner_question_group');
    }
}
