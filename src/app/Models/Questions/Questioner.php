<?php

namespace App\Models\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Relations\QuestionerRelationTrait;
use App\Models\Sale\Order;
use App\Models\Sale\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Questioner extends BaseModel
{

    use QuestionerRelationTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'questioners';
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
    const COLUMN_SLUG = 'slug';
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
     * @return string
     */
    public function getSlug(): string
    {
        return $this->{self::COLUMN_SLUG};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSlug(string $value): self
    {
        $this->{self::COLUMN_SLUG} = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->{self::COLUMN_PRICE};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setPrice(int $value): self
    {
        $this->{self::COLUMN_PRICE} = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFree(): bool
    {
        return !$this->getPrice();
    }

    /**
     * @param int $questionerId
     * @return bool
     */
    public static function userPaidForQuestioner(int $questionerId): bool
    {
        return Order::paid()->forUser(Auth::id())->whereHas(
            'orderItems',
            function (Builder $query) use ($questionerId) {
                $query->where(OrderItem::COLUMN_QUESTIONER_ID, $questionerId);
            }
        )->exists();
    }

    /**
     * @param int $questionerId
     * @return bool
     */
    public static function isQuestionerAlreadyInCurrentCart(int $questionerId): bool
    {
        return Order::lastOrder()->open()->forUser(Auth::id())->whereHas(
            'orderItems',
            function (Builder $query) use ($questionerId) {
                $query->where(OrderItem::COLUMN_QUESTIONER_ID, $questionerId);
            }
        )->exists();
    }

    /**
     * @param int $questionerId
     * @return int
     */
    public static function getQuestionerPrice(int $questionerId): int
    {
        $questioner = self::whereId($questionerId)->first();

        return $questioner?->price ?? 0;
    }

}
