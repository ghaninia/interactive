<?php

use Illuminate\Support\Facades\Route;
use GhaniniaIR\Interactive\Http\Controllers\InteractiveTerminalController;

$prefixName = config("interactive.route.prefix_name");
$prefixName = sprintf("%s.", $prefixName);
$prefixRoute = config("interactive.route.prefix_route");

Route::name($prefixName)
    ->prefix($prefixRoute)
    ->group(function () {

        Route::post("set", [InteractiveTerminalController::class , "set"])->name("set");

    });


    