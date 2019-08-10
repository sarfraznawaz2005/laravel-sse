<?php

if (!function_exists('sse_notify')) {
    /**
     * @param $message
     * @param string $type : alert, success, error, warning, info
     * @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
     * @return mixed
     */
    function sse_notify($message, $type = 'info', $event = 'message')
    {
        $noty = app('SSE');

        return $noty->notify($message, $type, $event);
    }
}
