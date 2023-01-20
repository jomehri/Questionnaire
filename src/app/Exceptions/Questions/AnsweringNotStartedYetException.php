<?php

namespace App\Exceptions\Questions;

use App\Exceptions\BaseApiException;

class AnsweringNotStartedYetException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("answers/answer.exceptions.answeringNotStartedYet");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
