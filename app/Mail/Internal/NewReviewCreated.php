<?php

namespace App\Mail\Internal;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReviewCreated extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function build(): Mailable
    {
        $subject = 'Nueva opinión insertada';
        $bcc = [['email' => 'flavia@lifecole.com','name' => 'Flavia'],
            ['email' => 'eva@lifecole.com','name' => 'Eva'],
            ['email' => 'antonio@lifecole.com','name' => 'Antonio'],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        $html = 'Email Padre/Alumno: ' . $this->user->email . '<br/><br/>';
        $html .= 'Panel: https://admin.lifecole.com/review/list<br/><br/>';

        return $this->subject($subject)
            ->bcc($bcc)
            ->html($html);
    }

    private function getValue($key): string
    {
        return $this->msg[$key] ?? '';
    }
}
