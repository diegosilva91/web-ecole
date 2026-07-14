<?php

namespace App\Mail\Internal;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Throwable;

class ReportRequestError extends Mailable
{
    public function __construct(private string $url, private Request $request, private Throwable $error)
    {
    }

    public function build()
    {
        $subject = 'Error Request';
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

        $msg = $this->url . "\n";
        $msg .= "----------------------------\n\n\n";
        $msg .= $this->error . "\n";
        $msg .= "----------------------------\n\n\n";
        $msg .= $this->request . "\n";

        return $this
            ->subject($subject)
            ->to($to)
            ->html(nl2br($msg));
    }
}
