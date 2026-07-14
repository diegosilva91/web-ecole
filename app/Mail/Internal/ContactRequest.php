<?php

namespace App\Mail\Internal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;
use function env;

class ContactRequest extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $msg;

    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'solicitd de contacto-lifecole.com';
        $to = [
            ['email' => 'belen@lifecole.com', 'Belén'],
        ];
        $bcc = [['email' => 'belen@lifecole.com','name' => 'Belén'],
            ['email' => 'antonio@lifecole.com','name' => 'Antonio'],
            ['email' => 'paula@lifecole.com','name' => 'Paula'],
            ['email' => 'flavia@lifecole.com','name' => 'Flavia'],
            ['email' => 'katty@lifecole.com','name' => 'Katty'],
            ['email' => 'eva@lifecole.com','name' => 'Eva']
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $to = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this->subject($subject)
            ->cc($to)
            ->bcc($bcc)
            ->view('emails.internal.contact-message');
    }
}
