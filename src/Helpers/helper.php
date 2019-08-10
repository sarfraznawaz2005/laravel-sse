<?php

if (!function_exists('sse_notify')) {
    /**
     * @param $message
     * @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
     * @param string $type : alert, success, error, warning, info
     * @return mixed
     */
    function sse_notify($message, $event = 'message', $type = 'info')
    {
        $noty = app('SSE');

        return $noty->notify($message, $event, $type);
    }
}
