<?php

return [

    'validations' => [

        'titleIsRequired' => 'وارد کردن عنوان پرسشنامه الزامی است.',
        'titleIsTooLong' => 'عنوان پرسشنامه بیش از حد طولانی است.',
        'titleAlreadyExists' => 'دسته سوالاتی با این عنوان قبلا ثبت شده است.',
        'questionerIdsMustBeArray' => 'آرایه شماره پرسشنامه ها به شکل صحیح اسال نشده است.',
        'questionerIdsCanTakeOnlyOneId' => 'هر دسته از سوالات تنها می تواند به یک پرسشنامه متصل باشد.',
        'questionerIdNotFound' => 'شماره پرسشنامه ارسال شده :attribute یافت نشد.',
        'questionerIdIsRequired' => 'وارد کردن شماره پرسشنامه الزامی است.',
        'questionerIdMustBeInteger' => 'شماره پرسشنامه می باید به شکل عددی وارد شود.',
        'questionerDoesNotExist' => 'پرسشنامه ای با شماره انتخاب شده موجود نمی باشد. از صحت اطلاعات ورودی مطمین شوید.',

    ],

    'exceptions' => [
        'questionGroupCantBeDeletedSinceHasQuestions' => 'از آنجایی که سوالاتی به این گروه سوال متصل هستند امکان حذف آن موجود نمی باشد.'
    ]

];
