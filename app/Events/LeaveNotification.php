<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Auth;

class LeaveNotification extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $title;
    public $type;
    public $module;
    public $resource;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Array $data)
    {
		$this->user = Auth::user()->codigo_usuario;
		$this->type = $data['type'];
		$this->title = $data['title'];
		$this->module = $data['module'];
		$this->resource = $data['resource'];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
		return ['notification-channel'];
    }
}
