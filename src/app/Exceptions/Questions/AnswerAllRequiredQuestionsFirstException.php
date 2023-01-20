<?php

namespace App\Exceptions\Questions;

use App\Exceptions\BaseApiException;

class AnswerAllRequiredQuestionsFirstException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("answers/answer.exceptions.youNeedToAnswerTheseRequiredQuestionsFirst", $this->extraData);
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
