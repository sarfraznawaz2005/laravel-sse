<?php

Route::group(
    [
        'namespace' => 'Sarfraznawaz2005\SSE\Http\Controllers',
        'prefix' => 'sse'
    ],
    static function () {

        Route::get('notify', 'SSEController')->name('__sse_notify__');
    }
);
