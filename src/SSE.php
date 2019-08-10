<?php

namespace Sarfraznawaz2005\SSE;

use Sarfraznawaz2005\SSE\Models\SSELog;

class SSE
{
    /**
     * @var SSELog
     */
    protected $SSELog;

    public function __construct(SSELog $SSELog)
    {
        $this->SSELog = $SSELog;
    }

    /**
     * Notify SSE event.
     *
     * @param string $message : notification message
     * @param string $type : alert, success, error, warning, info
     * @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
     * @return bool
     */
    public function notify($message, $type = 'info', $event = 'message'): bool
    {
        return $this->SSELog->saveEvent($message, $type, $event);
    }
}
