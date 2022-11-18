<?php

namespace App\Models;

interface IBaseModel
{
    /**
     * @return string
     */
    static function getDBConnection(): string;

    /**
     * @return string
     */
    static function getDBTable(): string;

    /**
     * @return string
     */
    static function getGroup(): string;

    /**
     * @return bool
     */
    function hasId(): bool;

    /**
     * @return int
     */
    function getId(): int;

    /**
     * @return mixed
     */
    function delete();

    /**
     * @return mixed
     */
    function forceDelete();
}
