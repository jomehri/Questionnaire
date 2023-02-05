<?php

use App\Models\Questions\UserQuestionGroup;

return [

    'statuses' => [

        UserQuestionGroup::STATUS_BOUGHT => 'پرداخت شده',
        UserQuestionGroup::STATUS_STARTED => 'آعاز شده',
        UserQuestionGroup::STATUS_COMPLETED => 'تکمیل',
    ]

];
