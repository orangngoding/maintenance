<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');

});
// Auth::routes(['verify' => true]);
// Route::get('/test-mail', function () {
//     Mail::raw('Test email content', function ($message) {
//         $message->to('ginggie29@gmail.com')
//             ->subject('Test Email');
//     });

//     return 'Test email sent!';
// });
