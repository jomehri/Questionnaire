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
    const COLUMN_QUESTIONER_ID = 'questioner_id';

    /**
     * Omitted
     */
    const COLUMN_PRICE = 'price';

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

    /**
     * @return int
     * @deprecated TODO @aliJo
     */
    public function getPrice(): int
    {
        return $this->{self::COLUMN_PRICE};
    }

    /**
     * @return int
     */
    public function getQuestionerId(): int
    {
        return $this->{self::COLUMN_QUESTIONER_ID};
    }

    /**
     * @param int $value
     * @return QuestionGroup
     */
    public function setQuestionerId(int $value): self
    {
        $this->{self::COLUMN_QUESTIONER_ID} = $value;

        return $this;
    }

}
