<?php

namespace Sarfraznawaz2005\SSE\Models;

use Illuminate\Database\Eloquent\Model;

class SSELog extends Model
{
    protected $table = 'sselogs';

    protected $fillable = [
        'user_id',
        'message',
        'event',
        'type',
        'delivered',
    ];

    /**
     * Saves SSE event in database table.
     *
     * @param $message
     * @param $type
     * @param $event
     * @return bool
     */
    public function saveEvent($message, $type, $event): bool
    {
        $this->deleteProcessed();

        $data['message'] = $message;
        $data['event'] = $event;
        $data['type'] = $type;

        if (config('sse.append_user_id') && auth()->check()) {
            $data['user_id'] = auth()->user()->getAuthIdentifier();
        }

        $this->fill($data);

        return $this->save();
    }

    /**
     * Deletes already processed events
     */
    public function deleteProcessed()
    {
        if (!config('sse.keep_events_logs')) {
            $this->where('delivered', '1')->delete();
        }
    }
}
