<?php
use App\Http\Controllers\ContenuController;

Route::get('/contenus', [ContenuController::class, 'apiContenus']);
