<?php

return [

    'validations' => [

        'titleIsRequired' => 'وارد کردن عنوان پرسشنامه الزامی است.',
        'titleIsTooLong' => 'عنوان پرسشنامه بیش از حد طولانی است.',
        'titleAlreadyExists' => 'پرسشنامه ای با این عنوان قبلا ثبت شده است.',
        'questionerIdsMustBeArray' => 'آرایه شماره پرسشنامه ها به شکل صحیح اسال نشده است.',
        'questionerIdNotFound' => 'شماره پرسشنامه ارسال شده :attribute یافت نشد.',

    ],

    'exceptions' => [
        'questionGroupCantBeDeletedSinceHasQuestions' => 'از آنجایی که سوالاتی به این گروه سوال متصل هستند امکان حذف آن موجود نمی باشد.'
    ]

];
