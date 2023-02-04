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
        $table->unsignedInteger(UserQuestionGroup::COLUMN_QUESTIONER_ID)
            ->nullable(false);
        $table->unsignedInteger(UserQuestionGroup::COLUMN_PAID_AMOUNT)
            ->nullable();
        $table->enum(UserQuestionGroup::COLUMN_STATUS, UserQuestionGroup::STATUSES)
            ->nullable(false);
        $table->dateTime(UserQuestionGroup::COLUMN_BOUGHT_AT)
            ->nullable();
        $table->dateTime(UserQuestionGroup::COLUMN_STARTED_AT)
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
        // Add columns
        if (!$this->hasColumn(UserQuestionGroup::COLUMN_QUESTIONER_ID)) {
            $table->unsignedInteger(UserQuestionGroup::COLUMN_QUESTIONER_ID)
                ->nullable(false)
                ->after(UserQuestionGroup::COLUMN_USER_ID);
        }

        if (!$this->hasColumn(UserQuestionGroup::COLUMN_STARTED_AT)) {
            $table->dateTime(UserQuestionGroup::COLUMN_STARTED_AT)
                ->nullable()
                ->after(UserQuestionGroup::COLUMN_BOUGHT_AT);
        }

        // Drop columns
        if ($this->hasColumn(UserQuestionGroup::COLUMN_QUESTION_GROUP_ID)) {
            $table->dropColumn(UserQuestionGroup::COLUMN_QUESTION_GROUP_ID);
        }

        if ($this->hasColumn('started')) {
            $table->dropColumn('started');
        }
    }
}
