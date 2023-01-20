<?php

namespace App\Exceptions\Questions;

use App\Exceptions\BaseApiException;

class AnsweringAlreadyFinishedException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("answers/answer.exceptions.answeringAlreadyFinished");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
