<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewSingleImageUploadedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
