<?php

use App\Models\BaseModel;
use App\Models\Blog\Blog;
use App\Models\Questions\Question;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogsTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(Blog::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string(Blog::COLUMN_TITLE, 250)
            ->nullable(false);
        $table->string(Blog::COLUMN_SLUG, 250)
            ->nullable(false);
        $table->string(Blog::COLUMN_IMAGE_PATH, 250)
            ->nullable(false);
        $table->text(Blog::COLUMN_BODY)
            ->nullable(false);
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
    }
}
