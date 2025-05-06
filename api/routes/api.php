<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/ping", function () {
    return response()->json([
        "message" => "pong",
        "datetime" => Carbon\Carbon::now()
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
