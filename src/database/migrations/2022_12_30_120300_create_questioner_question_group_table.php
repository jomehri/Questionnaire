<?php

use App\Models\Questions\Questioner;
use App\Database\Migration\BaseMigration;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionerQuestionGroupTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('questioner_question_group');
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->unsignedInteger('questioner_id')
            ->nullable(false);
        $table->unsignedInteger('question_group_id')
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
