<?php

use Illuminate\Database\Schema\Blueprint;
use App\Database\Migration\BaseMigration;
use App\Models\Questions\UserQuestionGroup;

class CreateUserQuestionGroupsTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(UserQuestionGroup::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->unsignedInteger(UserQuestionGroup::COLUMN_USER_ID)
            ->nullable(false);
        $table->unsignedInteger(UserQuestionGroup::COLUMN_QUESTION_GROUP_ID)
            ->nullable(false);
        $table->unsignedInteger(UserQuestionGroup::COLUMN_PAID_AMOUNT)
            ->nullable();
        $table->enum(UserQuestionGroup::COLUMN_STATUS, UserQuestionGroup::STATUSES)
            ->nullable(false);
        $table->dateTime(UserQuestionGroup::COLUMN_BOUGHT_AT)
            ->nullable();
        $table->dateTime(UserQuestionGroup::STATUS_STARTED)
            ->nullable();
        $table->dateTime(UserQuestionGroup::COLUMN_COMPLETED_AT)
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
