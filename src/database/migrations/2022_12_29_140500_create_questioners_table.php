<?php

use App\Models\Questions\Questioner;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionersTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(Questioner::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string(Questioner::COLUMN_TITLE, 250)
            ->nullable(false);
        $table->string(Questioner::COLUMN_SLUG, 250)
            ->nullable(false);
        $table->unsignedInteger(Questioner::COLUMN_PRICE)
            ->default(0)
            ->nullable(false);
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
        /**
         * Add Columns
         */
        if (!$this->hasColumn(Questioner::COLUMN_SLUG)) {
            $table->string(Questioner::COLUMN_SLUG, 250)
                ->nullable(false)
                ->after(Questioner::COLUMN_TITLE);
        }

        // add new columns
        if (!$this->hasColumn(Questioner::COLUMN_PRICE)) {
            $table->unsignedInteger(Questioner::COLUMN_PRICE)
                ->default(0)
                ->nullable(false)
                ->after(Questioner::COLUMN_SLUG);
        }
    }
}
