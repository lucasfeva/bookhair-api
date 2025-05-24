<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn(): array => [config('app.name')]);
