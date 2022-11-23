<?php

use App\Models\Basic\User;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(User::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string(User::COLUMN_FIRST_NAME, 50)
            ->nullable(true);
        $table->string(User::COLUMN_LAST_NAME, 100)
            ->nullable(true);
        $table->string(User::COLUMN_MOBILE, 11)
            ->nullable(false)
            ->unique();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
    }
}

;
