<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dit/is/een/test/', function (){
    return view('test');
});

Route::get('/dit/is/een/test2/', function (){
    return view('test2')->with('varnaam', config('database.default'));
});

Route::get('/param/{id}/', 'controller@method' )->where('id', '[0-9]+');

Route::get('/products/', 'TestController@index');

Route::get('/showDatabase/', function (){
   $db = DB::table('roles')->get();
   return view('showDB', ['db'=>$db]);
});


Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

Route::get('/ticket/create', 'TicketController@create')
    ->name('ticket_create');

Route::post('ticket/save', 'TicketController@save')
    ->name('ticket_save');

Route::get('ticket/index_customer', 'TicketController@index')
    ->name('ticket_index');

Route::get('ticket/{id}/show', 'TicketController@show')
    ->name('ticket_show');

Route::put('ticket/{id}/update', 'TicketController@update')
    ->name('ticket_update');

Route::post('ticket/{id}/comment/save', 'CommentController@save')
    ->name('comment_save');

Route::get('ticket/index_helpdesk', 'TicketController@index_helpdesk')
            ->name('ticket_index_helpdesk');

Route::put('ticket/{id}/ticket_close', 'TicketController@close')
            ->name('ticket_close');

Route::put('ticket/{id}/ticket_claim', 'TicketController@claim')
            ->name('ticket_claim');

Route::put('ticket/{id}/ticket_unclaim', 'TicketController@unclaim')
            ->name('ticket_unclaim');

Route::put('ticket/{id}/ticket_escalate', 'TicketController@escalate')
            ->name('ticket_escalate');

Route::put('ticket/{id}/ticket_de_escalate', 'TicketController@de_escalate')
    ->name('ticket_de_escalate');
