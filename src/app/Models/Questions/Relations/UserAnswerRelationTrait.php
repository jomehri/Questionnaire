<?php

namespace App\Models\Questions\Relations;

use App\Models\Basic\User;
use App\Models\Questions\Question;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserAnswerRelationTrait
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

}
