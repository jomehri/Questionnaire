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
