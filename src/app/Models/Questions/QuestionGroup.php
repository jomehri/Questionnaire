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
     * @param int|null $value
     *
     * @return $this
     * @deprecated TODO @aliJo
     */
    public function setPrice(?int $value): self
    {
        $this->{self::COLUMN_PRICE} = $value;

        return $this;
    }

}
