<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model implements IBaseModel
{
    use SoftDeletes, HasFactory;

    const COLUMN_ID = 'id';
    const COLUMN_DELETED_AT = 'deleted_at';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->connection = $this->getDBConnection();

        $this->table = $this->getDBTable();

        parent::__construct($attributes);
    }

    /**
     * @return string
     */
    public static function getDBConnection(): string
    {
        return 'mysql';
    }

    /**
     * @return string
     */
    abstract public static function getDBTable(): string;

    /**
     * @return string
     */
    abstract public static function getGroup(): string;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->{self::COLUMN_ID};
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setId(int $value): self
    {
        $this->{self::COLUMN_ID} = $value;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->{self::COLUMN_ID} !== null;
    }

    /**
     * @return Carbon|null
     */
    public function getDeletedAt(): ?Carbon
    {
        if ($this->{self::COLUMN_DELETED_AT} === null) {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_DELETED_AT});
    }

    /**
     * @param Carbon|null $value
     *
     * @return $this
     */
    public function setDeletedAt(?Carbon $value): self
    {
        $this->{self::COLUMN_DELETED_AT} = $value;

        return $this;
    }

    /**
     * @param string $col
     * @param string $alias
     * @param bool $with_table
     *
     * @return string
     */
    public static function getColumns(string $col = '*', string $alias = '', bool $with_table = true): string
    {
        if ($col == '*') {
            $alias = '';
        }

        return ($with_table ? static::getDBTable() . '.' : '') . $col . ($alias ? ' AS ' . $alias : '');
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        parent::creating(fn(BaseModel $baseModel) => $baseModel->onCreating());
        parent::created(fn(BaseModel $baseModel) => $baseModel->onCreated());
        parent::updating(fn(BaseModel $baseModel) => $baseModel->onUpdating());
        parent::updated(fn(BaseModel $baseModel) => $baseModel->onUpdated());
        parent::saving(fn(BaseModel $baseModel) => $baseModel->onSaving());
        parent::saved(fn(BaseModel $baseModel) => $baseModel->onSaved());
        parent::deleting(fn(BaseModel $baseModel) => $baseModel->onDeleting());
        parent::deleted(fn(BaseModel $baseModel) => $baseModel->onDeleted());
    }

    /**
     * What to do on creating
     *
     * @return $this|null
     */
    protected function onCreating(): ?self
    {
        return $this;
    }

    /**
     * What to do when model created
     *
     */
    protected function onCreated()
    {
    }

    /**
     * What to do on updating
     *
     * @return $this|null
     */
    protected function onUpdating(): ?self
    {
        return $this;
    }

    /**
     * What to do when model updated
     */
    protected function onUpdated()
    {
    }

    /**
     * What to do on saving
     *
     * @return $this|null
     */
    protected function onSaving(): ?self
    {
        return $this;
    }

    /**
     * What to do when model saved
     */
    protected function onSaved()
    {
    }

    /**
     * What to do on deleting
     *
     * @return $this|null
     */
    protected function onDeleting(): ?self
    {
        return $this;
    }

    /**
     * What to do when model deleted
     */
    protected function onDeleted()
    {
    }

}
