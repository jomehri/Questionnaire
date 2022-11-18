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
        $table->string(User::COLUMN_NAME, 100)
            ->nullable(false);
        $table->string(User::COLUMN_EMAIL, 150)
            ->nullable(false)
            ->unique();
        $table->decimal(User::COLUMN_BALANCE, 10, 2)
            ->nullable(false)
            ->default(0);
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
