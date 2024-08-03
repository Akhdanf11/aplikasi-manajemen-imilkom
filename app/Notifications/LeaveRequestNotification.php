<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestNotification extends Notification
{
    use Queueable;

    protected $leaveRequest;

    public function __construct($leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You have a new leave request.')
                    ->action('View Request', url('/leave-requests/' . $this->leaveRequest->id))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'leave_request_id' => $this->leaveRequest->id,
            'start_date' => $this->leaveRequest->start_date,
            'end_date' => $this->leaveRequest->end_date,
            'reason' => $this->leaveRequest->reason,
        ];
    }
}

