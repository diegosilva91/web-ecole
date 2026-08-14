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
        $subject = 'solicitd de contacto-mi-empresa.com';
        $to = [
            ['email' => 'belen@mi-empresa.com', 'Belén'],
        ];
        $bcc = [['email' => 'belen@mi-empresa.com','name' => 'Belén'],
            ['email' => 'antonio@mi-empresa.com','name' => 'Antonio'],
            ['email' => 'paula@mi-empresa.com','name' => 'Paula'],
            ['email' => 'flavia@mi-empresa.com','name' => 'Flavia'],
            ['email' => 'katty@mi-empresa.com','name' => 'Katty'],
            ['email' => 'eva@mi-empresa.com','name' => 'Eva']
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
