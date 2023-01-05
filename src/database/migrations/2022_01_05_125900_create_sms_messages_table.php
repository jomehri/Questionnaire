<?php

use App\Models\Basic\SmsMessage;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsMessagesTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(SmsMessage::getDBTable());
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string(SmsMessage::COLUMN_RECEIVER, 20)->nullable(false);
        $table->text(SmsMessage::COLUMN_MESSAGE)->nullable(false);
        $table->boolean(SmsMessage::COLUMN_SENT)->nullable(false)->default(true);
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
    }
}
