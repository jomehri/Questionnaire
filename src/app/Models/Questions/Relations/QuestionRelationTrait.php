<?php

namespace App\Models\Questions\Relations;

use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait QuestionRelationTrait
{

    /**
     * @return BelongsTo
     */
    public function questionGroup(): BelongsTo
    {
        return $this->belongsTo(QuestionGroup::class);
    }
}
