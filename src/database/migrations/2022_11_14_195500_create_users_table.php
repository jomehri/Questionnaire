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
            ->nullable();
        $table->string(User::COLUMN_LAST_NAME, 100)
            ->nullable();
        $table->string(User::COLUMN_MOBILE, 11)
            ->nullable(false)
            ->unique();
        $table->string(User::COLUMN_PIN_CODE, 7)
            ->nullable();
        $table->dateTime(User::COLUMN_PIN_EXPIRE_AT)
            ->nullable();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
        /** New Columns */
        if (!$this->hasColumn(User::COLUMN_PIN_EXPIRE_AT)) {
            $table->dateTime(User::COLUMN_PIN_EXPIRE_AT)
                ->nullable()
                ->after(User::COLUMN_PIN_CODE);
        }
    }
}
