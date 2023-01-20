<?php

namespace App\Models\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Scopes\UserAnswerScopeTrait;
use App\Models\Questions\Relations\UserAnswerRelationTrait;

class UserAnswer extends BaseModel
{

    use UserAnswerRelationTrait, UserAnswerScopeTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'user_answers';
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
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_QUESTION_ID = 'question_id';
    const COLUMN_ANSWER = 'answer';
    const COLUMN_SOLVE = 'solve';


    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->{self::COLUMN_USER_ID};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->{self::COLUMN_USER_ID} = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuestionId(): int
    {
        return $this->{self::COLUMN_QUESTION_ID};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setQuestionId(int $value): self
    {
        $this->{self::COLUMN_QUESTION_ID} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->{self::COLUMN_ANSWER};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAnswer(string $value): self
    {
        $this->{self::COLUMN_ANSWER} = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSolve(): ?string
    {
        return $this->{self::COLUMN_SOLVE};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSolve(string $value): self
    {
        $this->{self::COLUMN_SOLVE} = $value;

        return $this;
    }

}
