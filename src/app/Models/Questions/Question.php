<?php

namespace App\Models\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Scopes\QuestionScopeTrait;
use App\Models\Questions\Relations\QuestionRelationTrait;

class Question extends BaseModel
{

    use QuestionRelationTrait, QuestionScopeTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'questions';
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
    const COLUMN_QUESTION_GROUP_ID = 'question_group_id';
    const COLUMN_TITLE = 'title';
    const COLUMN_TYPE = 'type';
    const COLUMN_DESCRIPTION = 'description';

    /**
     * @return int
     */
    public function getQuestionGroupId(): int
    {
        return $this->{self::COLUMN_QUESTION_GROUP_ID};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setQuestionGroupId(int $value): self
    {
        $this->{self::COLUMN_QUESTION_GROUP_ID} = $value;

        return $this;
    }

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
     * @return string
     */
    public function getType(): string
    {
        return $this->{self::COLUMN_TYPE};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setType(string $value): self
    {
        $this->{self::COLUMN_TYPE} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->{self::COLUMN_DESCRIPTION};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->{self::COLUMN_DESCRIPTION} = $value;

        return $this;
    }

}
