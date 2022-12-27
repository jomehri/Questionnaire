<?php

return [

    'validation' => [
        /**
         * Login/Register requests
         */
        'firstNameTooLong' => 'نام کوچک وارد شده بیش از حد طولانی است.',
        'lastNameTooLong' => 'نام فامیلی وارد شده بیش از حد طولانی است.',
        'mobileNotUnique' => 'این شماره موبایل قبلا در سایت عضو شده است.',
        'mobileCharactersTooLong' => 'شماره موبایل وارد شده باید 11 رقم باشد.',
        'mobileFormatNotAllowed' => 'شماره موبایل می بایست 11 رقم باشد و با 09 شروع شود.',
        'userNotRegistered' => 'این شماره موبایل قبلا عضو سایت نشده است. ابتدا در سایت ثبت نام نمایید.',

        /**
         * Login
         */
        'pinIsRequired' => 'لطفا پین کد را وارد نمایید.',
        'pinLengthNotCorrect' => 'طول رشته پین کد وارد شده صحیح نیست.',
        'loginSuccessful' => 'شما وارد شدید.',

    ],

    'exception' => [
        'previousPinNotExpiredYet' => 'جهت درخواست رمز یک بار مصرف جدید شما میبایست :seconds ثانیه دیگر صبر نمایید.',
        'userMobileNotFound' => 'چنین کاربری با شماره همراه :mobile یافت نشد.',
        'userPinHasExpired' => 'پین کد شما منقضی شده است. لطفا مجدد اقدام نمایید.',
        'userPinIsIncorrect' => 'پین کد وارد شده صحیح نیست. لطفا مجدد تلاش نمایید.',
    ],

    'registerSuccess' => 'ثبت نام شما با موفقیت انجاد شد و رمز یک بار مصرف به شماره همراه :mobile ارسال شد.',
    'loginSuccess' => 'رمز یک بار مصرف به شماره همراه :mobile ارسال شد.',
];
