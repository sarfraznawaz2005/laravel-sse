<?php

namespace Sarfraznawaz2005\SSE\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Sarfraznawaz2005\SSE\Models\SSELog;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends BaseController
{
    /**
     * Notifies SSE events.
     *
     * @param SSELog $SSELog
     * @return StreamedResponse
     */
    public function stream(SSELog $SSELog)
    {
        $response = new StreamedResponse();

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        $response->setCallback(static function () use ($SSELog) {

            // if the connection has been closed by the client we better exit the loop
            if (connection_aborted()) {
                return;
            }

            $model = $SSELog->where('delivered', '0')->oldest()->first();

            echo ':' . str_repeat(' ', 2048) . "\n"; // 2 kB padding for IE
            echo "retry: 5000\n";

            if ($model) {

                $data = json_encode([
                    'message' => $model->message,
                    'type' => strtolower($model->type),
                    'time' => date('H:i:s A', strtotime($model->created_at)),
                ]);

                echo 'id: ' . $model->id . "\n";
                echo 'event: ' . $model->event . "\n";
                echo 'data: ' . $data . "\n\n";

                $model->delivered = '1';
                $model->save();

            } else {
                // no new data to send
                echo ": heartbeat\n\n";
            }

            ob_flush();
            flush();

            sleep(config('sse.interval'));
        });

        return $response->send();
    }
}
