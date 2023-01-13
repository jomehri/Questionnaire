<?php

namespace App\Models\Blog;

use App\Models\BaseModel;
use App\Models\Questions\Scopes\QuestionScopeTrait;
use App\Models\Questions\Relations\QuestionRelationTrait;

class Blog extends BaseModel
{

    use QuestionRelationTrait, QuestionScopeTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'blogs';
    }

    /**
     * @return string
     */
    public static function getGroup(): string
    {
        return 'Blog';
    }

    /**
     * Columns
     */
    const COLUMN_TITLE = 'title';
    const COLUMN_SLUG = 'slug';
    const COLUMN_IMAGE_PATH = 'image_path';

    const IMAGE_MIME_TYPE_JPG = 'jpg';
    const IMAGE_MIME_TYPE_JPEG = 'jpeg';
    const IMAGE_MIME_TYPE_PNG = 'png';
    const IMAGE_MIME_TYPES = [
        self::IMAGE_MIME_TYPE_JPG => self::IMAGE_MIME_TYPE_JPG,
        self::IMAGE_MIME_TYPE_JPEG => self::IMAGE_MIME_TYPE_JPEG,
        self::IMAGE_MIME_TYPE_PNG => self::IMAGE_MIME_TYPE_PNG,
    ];

    const IMAGE_FILE_MAX_SIZE = '2048';
    const COLUMN_BODY = 'body';

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
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->{self::COLUMN_IMAGE_PATH};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setImagePath(string $value): self
    {
        $this->{self::COLUMN_IMAGE_PATH} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->{self::COLUMN_BODY};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setBody(string $value): self
    {
        $this->{self::COLUMN_BODY} = $value;

        return $this;
    }

}
