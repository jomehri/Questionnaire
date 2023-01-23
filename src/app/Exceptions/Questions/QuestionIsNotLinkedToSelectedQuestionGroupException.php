<?php

namespace App\Exceptions\Questions;

use App\Exceptions\BaseApiException;

class QuestionIsNotLinkedToSelectedQuestionGroupException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("questions/question_group.exceptions.questionIsNotLinkedToSelectedQuestionGroupException");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
