<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeTeacher extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(private string $email, private string $name)
    {
    }

    public function build()
    {
        $subject = '¡Estás mas cerca de pertenecer a Mi-empresa!';
        $bcc = [
            ['email' => env('MAIL_FROM_ADDRESS'), 'name' => 'Mi-empresa'],
            ['email' => env('MAIL_USERNAME_MANAGER'), 'name' => 'Mi-empresa']
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this->to([
            ['email' => $this->email, 'name' => $this->name]
        ])
            ->bcc($bcc)
            ->subject($subject)
            ->view('emails.welcome-teacher');
    }
}
