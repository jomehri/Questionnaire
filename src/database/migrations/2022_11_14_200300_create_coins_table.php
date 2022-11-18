<?php

use App\Models\Sale\Coin;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoinsTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(Coin::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string(Coin::COLUMN_NAME, 100)
            ->nullable(false);
        $table->decimal(Coin::COLUMN_IN_STOCK, 10, 2, true)
            ->nullable(false)
            ->default(0);
        $table->decimal(Coin::COLUMN_PRICE, 10, 2, true)
            ->nullable(false);
        $table->enum(Coin::COLUMN_STATUS, Coin::STATUSES)
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

;
