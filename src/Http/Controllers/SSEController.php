<?php

namespace Sarfraznawaz2005\SSE\Http\Controllers;

use DateTime;
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
     * @throws \Exception
     */
    public function stream(SSELog $SSELog): StreamedResponse
    {
        $response = new StreamedResponse();

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        // delete expired/old
        $this->deleteOld($SSELog);

        $response->setCallback(function () use ($SSELog) {

            // if the connection has been closed by the client we better exit the loop
            if (connection_aborted()) {
                return;
            }

            $model = $SSELog->where('delivered', '0')->oldest()->first();

            echo ':' . str_repeat(' ', 2048) . "\n"; // 2 kB padding for IE
            echo "retry: 5000\n";

            if (!$model) {
                // no new data to send
                echo ": heartbeat\n\n";
            } else {

                $clientId = $this->getClientId();

                // check if we have notified this client
                $clientModel = $SSELog
                    ->where('message', $model->message)
                    ->where('client', $clientId)
                    ->first();

                if ($clientModel) {
                    // no new data to send
                    echo ": heartbeat\n\n";
                } else {

                    $data = json_encode([
                        'message' => $model->message,
                        'type' => strtolower($model->type),
                        'time' => date('H:i:s A', strtotime($model->created_at)),
                    ]);

                    echo 'id: ' . $model->id . "\n";
                    echo 'event: ' . $model->event . "\n";
                    echo 'data: ' . $data . "\n\n";

                    $clientModel = new $SSELog();
                    $clientModel->user_id = $model->user_id;
                    $clientModel->message = $model->message;
                    $clientModel->event = $model->event;
                    $clientModel->type = $model->type;
                    $clientModel->client = $clientId;
                    $clientModel->delivered = '1';
                    $clientModel->save();
                }
            }

            ob_flush();
            flush();

            sleep(config('sse.interval'));
        });

        return $response->send();
    }

    /**
     * Tries to identify different SSE connections
     *
     * @return string
     */
    protected function getClientId(): string
    {
        return md5(php_uname('n') . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
    }

    /**
     * @param SSELog $SSELog
     * @throws \Exception
     */
    public function deleteOld(SSELog $SSELog)
    {
        $date = new DateTime;
        $date->modify('-' . (config('sse.interval') * 2) . ' seconds');

        // delete client-specific records
        $SSELog
            ->where('created_at', '<=', $date->format('Y-m-d H:i:s'))
            ->where('client', '!=', '')
            ->delete();

        // update actual message as delivered
        $SSELog
            ->where('created_at', '<=', $date->format('Y-m-d H:i:s'))
            ->update(['delivered' => '1']);
    }
}
