<?php

use App\Models\Questions\UserAnswer;
use Illuminate\Database\Schema\Blueprint;
use App\Database\Migration\BaseMigration;

class CreateUserAnswersTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(UserAnswer::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->unsignedInteger(UserAnswer::COLUMN_USER_ID)
            ->nullable(false);
        $table->unsignedInteger(UserAnswer::COLUMN_QUESTION_ID)
            ->nullable(false);
        $table->text(UserAnswer::COLUMN_ANSWER)
            ->nullable(false);
        $table->text(UserAnswer::COLUMN_SOLVE)
            ->nullable();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
    }
}
