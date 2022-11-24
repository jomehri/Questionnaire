<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class BaseApiException
 *
 * @package Chapagha\Shared\App\Exceptions
 */
abstract class BaseApiException extends Exception
{
    /** @var array|null $extraData */
    public array $extraData;

    /**
     * @param Throwable|null $previous
     * @param array|null $extraData
     */
    public function __construct(Throwable $previous = null, ?array $extraData = [])
    {
        $this->extraData = $extraData;

        parent::__construct($this->getErrorMessage(), $this->getErrorCode(), $previous);
    }

    /**
     * @return string
     */
    public abstract function getErrorMessage(): string;

    /**
     * @return int
     */
    public abstract function getErrorCode(): int;

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return 422;
    }
}
