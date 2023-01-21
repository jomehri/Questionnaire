<?php

namespace App\Models\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Relations\QuestionerRelationTrait;

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

}
