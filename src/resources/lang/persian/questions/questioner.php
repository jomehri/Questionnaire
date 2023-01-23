<?php

return [

    'validations' => [

        'titleIsRequired' => 'وارد کردن عنوان پرسشنامه الزامی است.',
        'titleIsTooLong' => 'عنوان پرسشنامه بیش از حد طولانی است.',
        'titleAlreadyExists' => 'پرسشنامه ای با این عنوان قبلا ثبت شده است.',

        'slugIsRequired' => 'وارد کردن کیورد صفحه الزامی است.',
        'slugIsTooLong' => 'کیورد صفحه بیش از حد طولانی است.',
        'slugAlreadyExists' => 'پرسشنامه ای با این کیورد قبلا ثبت شده است.',
        'priceMustBeInteger' => 'قیمت می باید به شکل عدد صحیح و بدون اعشار باشد.',

    ],

    'exceptions' => [
        'questionerCantBeDeletedSinceHasQuestionGroups' => 'از آنجایی که گروه سوالاتی به این پرسشنامه متصل هستند امکان حذف آن موجود نمی باشد.'
    ]

];
