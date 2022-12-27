<?php

return [

    'validation' => [
        'firstNameTooLong' => 'نام کوچک وارد شده بیش از حد طولانی است.',
        'lastNameTooLong' => 'نام فامیلی وارد شده بیش از حد طولانی است.',
        'mobileNotUnique' => 'این شماره موبایل قبلا در سایت عضو شده است.',
        'mobileCharactersTooLong' => 'شماره موبایل وارد شده باید 11 رقم باشد.',
        'mobileFormatNotAllowed' => 'شماره موبایل می بایست 11 رقم باشد و با 09 شروع شود.',
        'userNotRegistered' => 'این شماره موبایل قبلا عضو سایت نشده است. ابتدا در سایت ثبت نام نمایید.',
    ],

    'exception' => [
        'previousPinNotExpiredYet' => 'جهت درخواست رمز یک بار مصرف جدید شما میبایست :seconds ثانیه دیگر صبر نمایید.',
    ],

    'registerSuccess' => 'ثبت نام شما با موفقیت انجاد شد و رمز یک بار مصرف به شماره همراه :mobile ارسال شد.',
    'loginSuccess' => 'رمز یک بار مصرف به شماره همراه :mobile ارسال شد.',
];
