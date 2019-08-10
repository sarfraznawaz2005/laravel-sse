<?php

Route::group(['prefix' => 'sse'], static function () {
    Route::get('notify', \Sarfraznawaz2005\SSE\Http\Controllers\SSEController::class)->name('__sse_notify__');
});

