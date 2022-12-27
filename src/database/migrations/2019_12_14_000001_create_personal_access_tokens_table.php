<?php

use Illuminate\Support\Facades\Schema;
use App\Database\Migration\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonalAccessTokensTable extends BaseMigration
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('personal_access_tokens');
    }

    /**
     * Run the migrations.
     *
     * @param Blueprint $table
     * @return void
     */
    protected function createTable(Blueprint $table): void
    {
        $table->bigIncrements('id');
        $table->morphs('tokenable');
        $table->string('name');
        $table->string('token', 64)->unique();
        $table->text('abilities')->nullable();
        $table->timestamp('last_used_at')->nullable();
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function alterTable(Blueprint $table): void
    {
        /**
         * Add Columns
         */
        if (!$this->hasColumn('expires_at')) {
            $table->timestamp('expires_at')
                ->nullable()
                ->after('last_used_at');
        }
    }
}
