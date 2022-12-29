<?php

namespace App\Exceptions\Questions;

use App\Exceptions\BaseApiException;

class QuestionerWithQuestionsCantBeDeletedException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("questions/questioner.exceptions.questionerCantBeDeletedSinceHasQuestionGroups");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
