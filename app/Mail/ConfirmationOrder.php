<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationOrder extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public $user,
        public $course,
        public $promotion,
        public $promotionPurchasePayment,
        public $userAssistant
    ) {
    }

    public function build(): ConfirmationOrder
    {
        $subject = '¡Tu curso de Lifecole de ' . $this->course->title . '! Gracias por tu compra.';
        $bcc = [
            ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER2'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER3'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER4'), 'name' => env('APP_NAME')],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $bcc = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this->to([
            ['email' => $this->user->email, 'name' => 'Dear customer']
        ])
            ->bcc($bcc)
            ->subject($subject)
            ->view('emails.payment-success');
    }
}
