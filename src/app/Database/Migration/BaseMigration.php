<?php

namespace App\Database\Migration;

use Exception;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

abstract class BaseMigration extends Migration
{
    private $table;
    private $doctrineTable;
    private $hasBigInt;

    /**
     * @param string $table
     * @param bool $hasBigInt
     */
    public function __construct(string $table, bool $hasBigInt = false)
    {
        $this->table = $table;
        $this->hasBigInt = $hasBigInt;

        $connection = Schema::getConnection();
        $schemaManager = $connection->getDoctrineSchemaManager();
        $schemaManager->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $this->doctrineTable = $schemaManager->listTableDetails($table);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) {
            Schema::table($this->table, function (Blueprint $table) {
                $this->alterTable($table);
            });
        } else {
            Schema::create($this->table, function (Blueprint $table) {
                $this->appendIdColumn($table);
                $this->createTable($table);
                $this->appendTimestampsColumn($table);
                $table->softDeletes();
            });
        }
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function appendIdColumn(Blueprint $table)
    {
        if ($this->hasBigInt) {
            $table->bigIncrements(BaseModel::COLUMN_ID);
        } else {
            $table->increments(BaseModel::COLUMN_ID);
        }

    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected function appendTimestampsColumn(Blueprint $table)
    {
        $table->timestamps();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    protected abstract function createTable(Blueprint $table) :void;

    /**
     * @param Blueprint $table
     * @return void
     */
    protected abstract function alterTable(Blueprint $table): void;

    /**
     * @param string $indexName
     * @return bool
     */
    protected function hasIndex(string $indexName): bool
    {
        return $this->doctrineTable->hasIndex($indexName);
    }

    /**
     * @return bool
     */
    protected function hasPrimaryKey(): bool
    {
        return $this->doctrineTable->hasPrimaryKey();
    }

    /**
     * @param string $column
     * @return bool
     */
    protected function hasColumn(string $column): bool
    {
        return $this->doctrineTable->hasColumn($column);
    }

    /**
     * @param string $column
     *
     * @return string|null
     * @throws Exception
     */
    protected function getColumnType(string $column): ?string
    {
        try {
            return ($this->doctrineTable->hasColumn($column)) ?
                $this->doctrineTable->getColumn($column)->getType()->getName() :
                null;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param string $column
     * @param string $type
     *
     * @return bool
     * @throws Exception
     */
    protected function hasType(string $column, string $type): bool
    {
        if ($this->doctrineTable->hasColumn($column)) {
            try {
                return ($this->doctrineTable->getColumn($column)->getType()->getName() == $type);
            } catch (Exception $exception) {
                throw $exception;
            }
        } else {
            return false;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
