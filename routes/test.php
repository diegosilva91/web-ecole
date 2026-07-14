<?php

use Illuminate\Support\Facades\Route;

Route::get('/mails/extern/welcome-user/{token}','Test\ExternMailsController@welcomeUser');
Route::get('/mails/extern/welcome-teacher/{token}','Test\ExternMailsController@welcomeTeacher');
Route::get('/mails/extern/completed-course/{token}','Test\ExternMailsController@completedCourse');
Route::get('/mails/extern/reminder-5/{token}','Test\ExternMailsController@reminder5');
Route::get('/mails/extern/reminder-10/{token}','Test\ExternMailsController@reminder10');
Route::get('/mails/extern/reminder-15/{token}','Test\ExternMailsController@reminder15');
Route::get('/mails/extern/purchaseCard/{token}','Test\ExternMailsController@purchaseCard');
Route::get('/mails/extern/purchasePaypal/{token}','Test\ExternMailsController@purchasePaypal');
Route::get('/mails/extern/purchaseTransfer/{token}','Test\ExternMailsController@purchaseTransfer');
Route::get('/mails/extern/purchaseSepa/{token}','Test\ExternMailsController@purchaseSepa');
Route::get('/mails/extern/paymentSepa/{token}','Test\ExternMailsController@paymentSepa');

Route::get('/supplant/{token}','Test\SupplantController@supplant');

Route::get('/logs/message','Test\LogsController@message');
Route::get('/logs/request','Test\LogsController@request');

Route::get('/antonio','Test\AntonioController@execute');

Route::get('/menu/test','Test\TestMenuController@index');

Route::get('test',function (){
//        Artisan::call('tech:copy_mail_jobs');
    Artisan::call('new_emails:send_users_without_promotions_purchase 5 --send_email=true --stage=1');
    Artisan::call('new_emails:send_users_without_promotions_purchase 10 --send_email=true --stage=2');
    Artisan::call('new_emails:send_users_without_promotions_purchase 15 --send_email=true --stage=3');
});