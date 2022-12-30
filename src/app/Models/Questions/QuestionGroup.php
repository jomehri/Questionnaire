<?php

namespace App\Models\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Relations\QuestionGroupRelationTrait;

class QuestionGroup extends BaseModel
{

    use QuestionGroupRelationTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'question_groups';
    }

    /**
     * @return string
     */
    public static function getGroup(): string
    {
        return 'Question';
    }

    /**
     * Columns
     */
    const COLUMN_TITLE = 'title';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->{self::COLUMN_TITLE};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->{self::COLUMN_TITLE} = $value;

        return $this;
    }

}
