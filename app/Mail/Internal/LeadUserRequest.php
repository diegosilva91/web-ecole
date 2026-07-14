<?php

namespace App\Mail\Internal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;
use function env;

class LeadUserRequest extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $msg;

    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function build(): Mailable
    {
        $subject = 'New Lead Alert!';
        $bcc = [['email' => 'belen@lifecole.com','name' => 'Belén'],
            ['email' => 'katty@lifecole.com','name' => 'Katty'],
            ['email' => 'flavia@lifecole.com','name' => 'Flavia'],
            ['email' => 'paula@lifecole.com','name' => 'Paula'],
            ['email' => 'eva@lifecole.com','name' => 'Eva'],
            ['email' => 'antonio@lifecole.com','name' => 'Antonio'],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        $html = 'Email: ' . $this->getValue('email') . '<br/><br/>';
        $html .= 'Teléfono: ' . $this->getValue('phone') . '<br/><br/>';
        $html .= 'Categoría: ' . $this->getValue('category') . '<br/><br/>';
        $html .= 'Nombre: ' . $this->getValue('name') . '<br/><br/>';

        return $this->subject($subject)
            ->bcc($bcc)
            ->html($html);
    }

    private function getValue($key): string
    {
        return $this->msg[$key] ?? '';
    }
}
