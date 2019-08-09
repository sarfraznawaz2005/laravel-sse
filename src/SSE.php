<?php

namespace Sarfraznawaz2005\Noty;

use Sarfraznawaz2005\Noty\Exceptions\NotyException;

class SSE
{
    private $session;

    /**
     * A new instance.
     *
     * @param SessionStore $session
     */
    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }

    /**
     * Flash message(s).
     *
     * @param  string $message : notification message
     * @param  string $type : notification type
     * @param array $options : custom config options
     * @return void
     * @throws NotyException
     */
    public function notify($message, $type = '', array $options = [])
    {
        $types = ['success', 'error', 'warning', 'info', 'alert'];
        $messages = session('noty.messages') ?: [];

        $options = array_merge(config('noty'), $options);

        $type = $type ?: config('noty.type');
        $type = $type ?: 'info';

        if ($message === null || !\trim($message)) {
            throw new NotyException('Message argument is required.');
        }

        if (!\in_array($type, $types, true)) {
            throw new NotyException('Invalid type specified. Valid types include: ' . implode(', ', $types));
        }

        $messages[] = [
            'text' => $message,
            'type' => $type,
            'options' => $options
        ];

        $this->session->flash('noty.messages', $messages);
    }
}
