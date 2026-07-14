<?php

namespace App\Mail\Internal;

use App\Course;
use App\Promotion;
use App\PromotionPurchasePayment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public PromotionPurchasePayment $promotionPurchasePayment,
        public Course $course,
        public User $user,
        public Promotion $promotion,
        public mixed $userAssistant
    ) {
    }

    public function build(): PaymentConfirmation
    {
        $subject = 'Nueva compra | Método de pago: ' . $this->promotionPurchasePayment->payment_method . '| Curso ' . $this->course->title;
        $to = [
            ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER2'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER3'), 'name' => env('APP_NAME')],
            ['email' => env('MAIL_USERNAME_MANAGER4'), 'name' => env('APP_NAME')],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $to = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this
            ->subject($subject)
            ->to($to)->view('emails.internal.checkout-errors');
    }
}
