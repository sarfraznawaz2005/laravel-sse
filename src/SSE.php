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
     * @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
     * @param string $type : alert, success, error, warning, info
     * @return bool
     */
    public function notify($message, $event = 'message', $type = 'info'): bool
    {
        return $this->SSELog->saveEvent($message, $event, $type);
    }
}
