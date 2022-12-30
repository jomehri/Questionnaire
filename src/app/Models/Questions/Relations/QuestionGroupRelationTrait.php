<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\Questioner;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait QuestionGroupRelationTrait
{

    /**
     * @return BelongsToMany
     */
    public function questioners(): BelongsToMany
    {
        return $this->belongsToMany(Questioner::class, 'questioner_question_group');
    }
}
