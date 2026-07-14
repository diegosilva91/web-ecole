<?php

namespace App\Mail\Internal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformationEvent extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(private array $data)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->data['subject'];
        $to = $this->data['to'];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $to = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this->subject($subject)
            ->cc($to)
            ->html($this->data['html']);
    }
}
