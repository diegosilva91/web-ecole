<?php

namespace App\Mail\Internal;

use Illuminate\Mail\Mailable;
use Throwable;

class ReportCommandError extends Mailable
{
    public function __construct(private string $command, private array $data, private Throwable $error)
    {
    }

    public function build()
    {
        $subject = 'Error Command';
        $to = [
            ['email' => 'antonio@lifecole.com', 'name' => 'Antonio'],
            ['email' => 'diego@lifecole.com', 'name' => 'Diego'],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $to = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        $msg = $this->command . "\n";
        $msg .= "----------------------------\n\n\n";
        $msg .= $this->error . "\n";
        $msg .= "----------------------------\n\n\n";
        foreach ($this->data as $key => $value) {
            $msg .= $key . ' : ' . $value . "\n";
        }

        return $this
            ->subject($subject)
            ->to($to)
            ->html(nl2br($msg));
    }
}
