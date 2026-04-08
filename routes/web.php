<?php

use App\Models\InviteLink;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/i/{link:token}', fn (InviteLink $link) => '');
