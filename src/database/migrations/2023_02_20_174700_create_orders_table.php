<?php

use App\Models\Sale\Order;
use Illuminate\Database\Schema\Blueprint;
use App\Database\Migration\BaseMigration;

class CreateOrdersTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(Order::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->unsignedInteger(Order::COLUMN_USER_ID)
            ->nullable(false);
        $table->unsignedBigInteger(Order::COLUMN_AMOUNT)
            ->default(0)
            ->nullable(false);
        $table->enum(Order::COLUMN_STATUS, Order::STATUSES)
            ->default(Order::STATUS_OPEN)
            ->nullable(false);
        $table->string(Order::COLUMN_BANK_REF_ID, 255)
            ->nullable();
        $table->timestamp(Order::COLUMN_PAID_AT)
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
