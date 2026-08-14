<?php

namespace App\Http\Controllers\Test;

use App\Course;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationOrder;
use App\Mail\ConfirmationSepaPayment;
use App\Mail\WelcomeTeacher;
use App\Mail\WelcomeUser;
use App\Notifications\PromotionEndAtUsers;
use App\Notifications\RemmindersUser;
use App\PromotionPurchasePayment;
use App\User;
use App\UserAssistant;
use Illuminate\Support\Facades\Mail;
use Mi-empresa\Api\Domain\Adapter\EncryptionAdapter;

class ExternMailsController extends Controller
{
    public function __construct(private EncryptionAdapter $encryptionAdapter)
    {
        //$this->middleware('auth.admin');
    }

    public function welcomeUser(string $token)
    {
        $data = $this->encryptionAdapter->decrypt($token);
        $user = User::where('email', 'antonio@mi-empresa.com')->first();

        $user->email = $data['email'];
        Mail::send(new WelcomeUser($user));

        return response('OK');
    }

    public function welcomeTeacher(string $token)
    {
        $data = $this->encryptionAdapter->decrypt($token);
        $email = $data['email'];
        $name = env('APP_NAME');
        Mail::send(new WelcomeTeacher($email, $name));

        return response('OK');
    }

    public function completedCourse(string $token)
    {
        $data = $this->encryptionAdapter->decrypt($token);

        //if (config('app.env') == 'production') {
        //$course = Course::where('id', '3121')->first();
        //$user = User::where('email', 'antonio@mi-empresa.com')->first();

        //} else {
            // Obtenemos un pedido válido
            $promotionPurchasePayment = PromotionPurchasePayment::where([ 'payment_method' => 'Credit/Debit card', 'payment_status' => 'succeeded'])->orderBy('id', 'desc')->first();
            $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
            $promotion = $promotionPurchase->promotion();
            /** @var Course $course */
            $course = $promotion->course()->first();
            $user = $promotionPurchase->user();
        //}

        $data['course_id'] = $course->id;
        $data['user_id'] = $user->id;
        $token = $this->encryptionAdapter->encrypt(json_encode($data));

        $user->email = $data['email'];
        $user->notify(new PromotionEndAtUsers($user, $course, $token));

        return response('OK');
    }

    public function reminder5(string $token)
    {
        return $this->reminder(5, $token);
    }

    public function reminder10(string $token)
    {
        return $this->reminder(10, $token);
    }

    public function reminder15(string $token)
    {
        return $this->reminder(15, $token);
    }

    private function reminder(string $days, string $token)
    {
        $data = $this->encryptionAdapter->decrypt($token);
        $user = User::where('email', 'antonio@mi-empresa.com')->first();

        $user->email = $data['email'];
        $user->notify(new RemmindersUser('emails.mail-' . $days . 'days', $user));

        return response('OK');
    }

    public function purchaseCard(string $token)
    {
        return $this->purchase($token, 'Credit/Debit card');
    }

    public function purchasePaypal(string $token)
    {
        return $this->purchase($token, 'paypal');
    }

    public function purchaseTransfer(string $token)
    {
        return $this->purchase($token, 'transfer');
    }

    public function purchaseSepa(string $token)
    {
        return $this->purchase($token, 'Sepa');
    }

    public function paymentSepa(string $token)
    {
        return $this->payment($token, 'Sepa');
    }

    private function purchase(string $token, $paymentMethod)
    {
        $data = $this->encryptionAdapter->decrypt($token);

        $promotionPurchasePayment = PromotionPurchasePayment::where('payment_method', $paymentMethod)->first();
        $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
        $promotion = $promotionPurchase->promotion();
        /** @var Course $course */
        $course = $promotion->course()->first();
        $user = $promotionPurchase->user();
        $promotionPurchaseAssitants = $promotionPurchase->promotionPurchaseAssistants()->get();
        $userAssistantIds = [];
        foreach ($promotionPurchaseAssitants as $promotionPurchaseAssitant) {
            $userAssistantIds[] = $promotionPurchaseAssitant->user_assistant_id;
        }
        $userAssistant = UserAssistant::whereIn('id', $userAssistantIds)->get();

        $user->email = $data['email'];
        Mail::send(new ConfirmationOrder(
            $user,
            $course,
            $promotion,
            $promotionPurchasePayment,
            $userAssistant,
        ));

        return response('OK');
    }

    private function payment(string $token, $paymentMethod)
    {
        $data = $this->encryptionAdapter->decrypt($token);

        $promotionPurchasePayment = PromotionPurchasePayment::where('payment_method', $paymentMethod)->first();
        $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
        $promotion = $promotionPurchase->promotion();
        /** @var Course $course */
        $course = $promotion->course()->first();
        $user = $promotionPurchase->user();
        $promotionPurchaseAssitants = $promotionPurchase->promotionPurchaseAssistants()->get();
        $userAssistantIds = [];
        foreach ($promotionPurchaseAssitants as $promotionPurchaseAssitant) {
            $userAssistantIds[] = $promotionPurchaseAssitant->user_assistant_id;
        }
        $userAssistant = UserAssistant::whereIn('id', $userAssistantIds)->get();

        $user->email = $data['email'];
        Mail::send(new ConfirmationSepaPayment(
            $user,
            $course,
            $promotion,
            $promotionPurchasePayment,
            $userAssistant,
        ));

        return response('OK');
    }
}
