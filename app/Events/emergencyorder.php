<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Orderesfromemergencystatus;
class emergencyorder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

public $order;
    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct(Orderesfromemergencystatus $order)
     {
         $this->order = $order;
     }

     /**
      * Get the channels the event should broadcast on.
      *
      * @return \Illuminate\Broadcasting\Channel|array
      */
     public function broadcastOn()
     {
         return new Channel('order');
     }

     /**
      * Get the data to broadcast.
      *
      * @return array
      */
     public function broadcastWith()
     {
         return ['order' => $this->order];
     }
}
