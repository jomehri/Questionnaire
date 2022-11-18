<?php

use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateFailedJobsTable extends BaseMigration
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct('failed_jobs');
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->string('uuid')->nullable()->unique();
        $table->text('connection');
        $table->text('queue');
        $table->longText('payload');
        $table->longText('exception');
        $table->timestamp('failed_at')->useCurrent();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
    }

}
