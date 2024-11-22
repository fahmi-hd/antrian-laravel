<?php

namespace App\Events;

use App\Models\Queue;
use App\Models\Service;
use App\Models\StatusQueue;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallQueueEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $antrian;
    public $audioFiles;
    public $counter;

    public function __construct($queue,$audioFiles,$counter)
    {
        $this->antrian=$queue;
        $this->audioFiles=$audioFiles;
        $this->counter=$counter;
    }

    public function broadcastWith(): array{
        return [
            'antrian' => $this->antrian,
            'counter' => $this->counter,
            'audio' => $this->audioFiles,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('call-queue'),
        ];
    }
}
