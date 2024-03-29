<?php

namespace App\Models\Questions;

use App\Models\BaseModel;
use App\Models\Basic\User;
use Illuminate\Support\Carbon;
use App\Models\Questions\Scopes\UserQuestionGroupScopeTrait;
use App\Models\Questions\Relations\UserQuestionGroupRelationTrait;

class UserQuestionGroup extends BaseModel
{

    use UserQuestionGroupRelationTrait, UserQuestionGroupScopeTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'user_question_groups';
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
    const COLUMN_QUESTIONER_ID = 'questioner_id';
    const COLUMN_PAID_AMOUNT = 'paid_amount';
    const COLUMN_STATUS = 'status';
    const COLUMN_BOUGHT_AT = 'bought_at';
    const COLUMN_STARTED_AT = 'started_at';
    const COLUMN_COMPLETED_AT = 'completed_at';

    const STATUS_BOUGHT = 'bought';
    const STATUS_STARTED = 'started';
    const STATUS_COMPLETED = 'completed';
    const STATUSES = [
        self::STATUS_BOUGHT => self::STATUS_BOUGHT,
        self::STATUS_STARTED => self::STATUS_STARTED,
        self::STATUS_COMPLETED => self::STATUS_COMPLETED,
    ];

    /**
     * Omitted
     */
    const COLUMN_QUESTION_GROUP_ID = 'question_group_id';

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
     * @return User
     */
    public function getUser(): User
    {
        return User::find($this->{self::COLUMN_USER_ID});
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
     *
     * @return $this
     */
    public function setQuestionerId(int $value): self
    {
        $this->{self::COLUMN_QUESTIONER_ID} = $value;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPaidAmount(): ?int
    {
        return $this->{self::COLUMN_PAID_AMOUNT};
    }

    /**
     * @param int|null $value
     *
     * @return $this
     */
    public function setPaidAmount(?int $value): self
    {
        $this->{self::COLUMN_PAID_AMOUNT} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->{self::COLUMN_STATUS};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setStatus(string $value): self
    {
        $this->{self::COLUMN_STATUS} = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function notStartedYet(): bool
    {
        return !$this->getStartedAt();
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return (bool)$this->getCompletedAt();
    }

    /**
     * @return Carbon|null
     */
    public function getStartedAt(): ?Carbon
    {
        if (!$this->{self::COLUMN_STARTED_AT}) {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_STARTED_AT});
    }

    /**
     * @param Carbon $value
     *
     * @return $this
     */
    public function setStartedAt(Carbon $value): self
    {
        $this->{self::COLUMN_STARTED_AT} = $value;

        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getBoughtAt(): ?Carbon
    {
        if (!$this->{self::COLUMN_BOUGHT_AT}) {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_BOUGHT_AT});
    }

    /**
     * @param Carbon $value
     *
     * @return $this
     */
    public function setBoughtAt(Carbon $value): self
    {
        $this->{self::COLUMN_BOUGHT_AT} = $value;

        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getCompletedAt(): ?Carbon
    {
        if (!$this->{self::COLUMN_COMPLETED_AT}) {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_COMPLETED_AT});
    }

    /**
     * @param Carbon $value
     *
     * @return $this
     */
    public function setCompletedAt(Carbon $value): self
    {
        $this->{self::COLUMN_COMPLETED_AT} = $value;

        return $this;
    }

    /**
     * @param int $userId
     * @param int $questionerId
     * @return static|null
     */
    public static function findByUserAndQuestionerId(int $userId, int $questionerId): null|self
    {
        return self::forUser($userId)->forQuestioner($questionerId)->first();
    }

    public static function getProgressPercent($questionerId, $userId): int
    {
        $questionsCount = Question::forQuestioner($questionerId)->count('id');
        $answeredCount = UserAnswer::forUser($userId)->forQuestioner($questionerId)->count('id');

        return ($answeredCount/$questionsCount) * 100;
    }

}
