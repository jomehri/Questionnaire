<?php

use App\Models\Sale\OrderItem;
use Illuminate\Database\Schema\Blueprint;
use App\Database\Migration\BaseMigration;

class CreateOrderItemsTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(OrderItem::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->unsignedInteger(OrderItem::COLUMN_ORDER_ID)
            ->nullable(false);
        $table->unsignedInteger(OrderItem::COLUMN_QUESTIONER_ID)
            ->nullable(false);
        $table->unsignedBigInteger(OrderItem::COLUMN_AMOUNT)
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
