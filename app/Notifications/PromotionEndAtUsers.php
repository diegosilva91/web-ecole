<?php

namespace App\Notifications;

use App\Course;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PromotionEndAtUsers extends Notification
{
    use Queueable;

    public function __construct(private User $user, private Course $course, private string $token)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $template = 'emails.completed-course';
        $subject = Lang::get($template . '.subject');
        $bcc = ['antonio@lifecole.com'];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [];
            $this->user->email = env('MAIL_FROM_ADDRESS');
        }

        return (new MailMessage())
            ->subject($subject)
            ->bcc($bcc)
            ->view(
                $template,
                ['course' => $this->course, 'user' => $this->user, 'token' => $this->token]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
