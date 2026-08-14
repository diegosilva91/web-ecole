<?php

namespace App\Mail\Internal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;
use function env;

class LeadTeacherRequest extends Mailable
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
        $subject = 'New Lead Profesor!';
        $bcc = [
            ['email' => 'oscar@mi-empresa.com','name' => 'Oscar'],
            ['email' => 'malcolm@mi-empresa.com','name' => 'Malcolm'],
            ['email' => 'antonio@mi-empresa.com','name' => 'Antonio'],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        $html = 'Email: ' . $this->getValue('email') . '<br/><br/>';
        $html .= 'Teléfono: ' . $this->getValue('phone') . '<br/><br/>';
        $html .= 'Nombre: ' . $this->getValue('name') . '<br/><br/>';
        $html .= 'Categoría: ' . $this->getValue('category') . '<br/><br/>';

        return $this->subject($subject)
            ->bcc($bcc)
            ->html($html);
    }

    private function getValue($key): string
    {
        return $this->msg[$key] ?? '';
    }
}
