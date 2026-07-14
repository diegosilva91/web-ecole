<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUser extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $subject = '¡Bienvenid@, ya formas parte de la comunidad Lifecoolers!';
        $bcc = [
            ['email' => env('MAIL_FROM_ADDRESS'), 'name' => 'Lifecole'],
            ['email' => env('MAIL_USERNAME_MANAGER'), 'name' => 'Lifecole'],
            ['email' => 'flavia@lifecole.com', 'name' => 'Flavia'],
            ['email' => 'katty@lifecole.com', 'name' => 'Katty'],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this->to([
            ['email' => $this->user->email, 'name' => 'Lifecoler']
        ])
            ->bcc($bcc)
            ->subject($subject)
            ->view('emails.welcome-user');
    }
}
