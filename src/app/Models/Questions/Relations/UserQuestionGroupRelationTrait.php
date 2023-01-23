<?php

namespace App\Models\Questions\Relations;

use App\Models\Basic\User;
use App\Models\Questions\Questioner;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Questioner $questioner
 */
trait UserQuestionGroupRelationTrait
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function questioner(): BelongsTo
    {
        return $this->belongsTo(Questioner::class);
    }

}
