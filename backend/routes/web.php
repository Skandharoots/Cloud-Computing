<?php

use Illuminate\Support\Facades\Route;

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
    return "<h1 style='color: #007bff; text-align: center;'>
                Welcome to Cloud Computing System Backend - Core v1.0.0
            </h1>
            <p style='font-size: 18px; text-align: center;'>
                <span style='color: #00aa00;'>
                    The backend is running successfully.
                </span>
                This acts as a pure API backend, so there won't be anything to visit here; just use the API.
                <br/>
                <span style='color: red;'>
                    If you encounter any issues, please contact backend administrator at <a href='mailto:242213@edu.p.lodz.pl'>242213@edu.p.lodz.pl</a>.
                </span>
            </p>";
});

require __DIR__.'/auth.php';
