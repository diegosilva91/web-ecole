<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class RemmindersUser extends Notification
{
    use Queueable;

    private User $user;
    private string $template;

    public function __construct(string $template, User $user)
    {
        $this->user = $user;
        $this->template = $template;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = Lang::get($this->template . '.subject');
        $bcc = ['antonio@mi-empresa.com'];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [];
            $this->user->email = env('MAIL_FROM_ADDRESS');
        }

        return (new MailMessage())
            ->subject($subject)
            ->bcc($bcc)
            ->view(
                $this->template,
                ['user' => $this->user]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
