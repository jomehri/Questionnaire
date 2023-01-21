<?php

return [

    'validations' => [

        'titleIsRequired' => 'وارد کردن عنوان پرسشنامه الزامی است.',
        'titleIsTooLong' => 'عنوان پرسشنامه بیش از حد طولانی است.',
        'titleAlreadyExists' => 'پرسشنامه ای با این عنوان قبلا ثبت شده است.',
        'questionerIdsMustBeArray' => 'آرایه شماره پرسشنامه ها به شکل صحیح اسال نشده است.',
        'questionerIdsCanTakeOnlyOneId' => 'هر دسته از سوالات تنها می تواند به یک پرسشنامه متصل باشد.',
        'questionerIdNotFound' => 'شماره پرسشنامه ارسال شده :attribute یافت نشد.',
        'priceMustBeInteger' => 'قیمت باید به صورت عددی وارد شود.',
        'PriceMustBePositive' => 'قیمت نمی تواند عدد منفی باشد.',

    ],

    'exceptions' => [
        'questionGroupCantBeDeletedSinceHasQuestions' => 'از آنجایی که سوالاتی به این گروه سوال متصل هستند امکان حذف آن موجود نمی باشد.'
    ]

];
