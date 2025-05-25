<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmpleadoController;

Route::apiResource('/empleados', EmpleadoController::class);