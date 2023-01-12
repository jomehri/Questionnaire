<?php

use App\Models\BaseModel;
use App\Models\Questions\Question;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(Question::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->unsignedInteger(Question::COLUMN_QUESTION_GROUP_ID)
            ->nullable(false);
        $table->string(Question::COLUMN_TITLE, 250)
            ->nullable(false);
        $table->string(Question::COLUMN_TYPE, 250)
            ->nullable(false);
        $table->text(Question::COLUMN_DESCRIPTION)
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
