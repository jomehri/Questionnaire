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
    const COLUMN_OPTIONS = 'options';
    const COLUMN_IS_REQUIRED = 'is_required';
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
     * @return array|null
     */
    public function getOptions(): ?array
    {
        if (empty($this->{self::COLUMN_OPTIONS})) {
            return null;
        }

        return json_decode($this->{self::COLUMN_OPTIONS}, true);
    }

    /**
     * @param array|null $value
     *
     * @return $this
     */
    public function setOptions(?array $value): self
    {
        if ($this->isText()) {
            $this->{self::COLUMN_OPTIONS} = null;
        }
        elseif (!!$value) {
            $this->{self::COLUMN_OPTIONS} = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRequired(): bool
    {
        return (bool)$this->{self::COLUMN_IS_REQUIRED};
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setIsRequired(bool $value): self
    {
        $this->{self::COLUMN_IS_REQUIRED} = $value;

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

    /**
     * @return bool
     */
    public function isText(): bool
    {
        return $this->getType() === 'text';
    }

}
