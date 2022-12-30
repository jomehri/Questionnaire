<?php

return [

    'validations' => [

        'titleIsRequired' => 'وارد کردن عنوان پرسشنامه الزامی است.',
        'titleIsTooLong' => 'عنوان پرسشنامه بیش از حد طولانی است.',
        'titleAlreadyExists' => 'پرسشنامه ای با این عنوان قبلا ثبت شده است.',
        
    ],

    'exceptions' => [
        'questionGroupCantBeDeletedSinceHasQuestionGroups' => 'از آنجایی که گروه سوالاتی به این پرسشنامه متصل هستند امکان حذف آن موجود نمی باشد.'
    ]

];
