<?php

use Illuminate\Support\Facades\Route;
use Luinuxscl\PostPilot\Http\Controllers\ProjectController;

Route::prefix('postpilot')->group(function () {
    Route::post('/projects', [ProjectController::class, 'store'])->name('postpilot.projects.store');
});
