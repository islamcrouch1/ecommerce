<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $user_id;
    public $sender_id;
    public $sender_name;
    public $sender_image;
    public $title_ar;
    public $title_en;
    public $body_ar;
    public $body_en;
    public $date;
    public $url;
    public $status;
    public $change_status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->user_id = $data['user_id'];
        $this->sender_id = $data['sender_id'];
        $this->sender_name = $data['sender_name'];
        $this->sender_image = $data['sender_image'];
        $this->title_ar = $data['title_ar'];
        $this->title_en = $data['title_en'];
        $this->body_ar = $data['body_ar'];
        $this->body_en = $data['body_en'];
        $this->date = $data['date'];
        $this->url = $data['url'];
        $this->status = $data['status'];
        $this->change_status = $data['change_status'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return ['new-notification'];
    }

    public function broadcastAs()
    {
        return 'notification-event';
    }
}
