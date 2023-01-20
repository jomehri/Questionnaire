<?php

namespace App\Models\Questions\Relations;

use App\Models\Basic\User;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserQuestionGroupRelationTrait
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function questionGroup(): BelongsTo
    {
        return $this->belongsTo(QuestionGroup::class, 'question_group_id');
    }

}
