<?php

namespace Lifecole\Shared\Domain\Event;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserHasFinishedPromotion
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(private int $courseId, private User $user)
    {
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
