<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public $receiverUser;
    public $user;
    public $getCount;
    public $lattestMessage;
    public $AllMessageCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chat, $receiverUser, $user,$getCount,$lattestMessage,$AllMessageCount)
    {
        $this->user = $user;
        $this->chat = $chat;
        $this->receiverUser = $receiverUser;
        $this->getCount= $getCount;
        $this->lattestMessage= $lattestMessage;
        $this->AllMessageCount= $AllMessageCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }
}
