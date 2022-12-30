<?php

use App\Models\Questions\QuestionGroup;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionGroupsTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(QuestionGroup::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string(QuestionGroup::COLUMN_TITLE, 250)
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
