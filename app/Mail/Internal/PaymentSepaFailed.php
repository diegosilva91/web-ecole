<?php

namespace App\Mail\Internal;

use App\Course;
use App\Promotion;
use App\PromotionPurchasePayment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSepaFailed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public PromotionPurchasePayment $promotionPurchasePayment,
        public Course $course,
        public User $user,
        public Promotion $promotion,
        public array $dataStripe
    ) {
    }

    public function build(): PaymentSepaFailed
    {
        $subject = 'Error pago suscripción | Usuario: ' . $this->user->email . ' | Curso ' . $this->course->title;
        $to = [
            ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')],
            ['email' => 'antonio@mi-empresa.com', 'name' => env('APP_NAME')],
            ['email' => 'diego@mi-empresa.com', 'name' => env('APP_NAME')],
            ['email' => 'belen@mi-empresa.com', 'name' => env('APP_NAME')],
            ['email' => 'eva@mi-empresa.com', 'name' => env('APP_NAME')],
        ];

        if (config('app.env') != 'production') {
            $subject = '(Testing) ' . $subject;
            $to = [
                ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('APP_NAME')]
            ];
        }

        return $this
            ->subject($subject)
            ->to($to)->view('emails.internal.payment-subscription-failed');
    }
}
