<?php

if (!function_exists('sse_notify')) {
    function sse_notify($message)
    {
        $noty = app('SSE');

        return $noty->notify($message);
    }
}
