<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendLeadUser;
use App\Mail\Internal\LeadUserRequest;
use Illuminate\Http\Request;
use Lifecole\Api\Domain\DTO\LeadUser;
use Lifecole\Shared\Domain\Repository\Mailer;

class MarketingLandingController extends Controller
{
    public function landingRequest(Request $request, Mailer $mailer)
    {
        $message = request()->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'name' => '',
            'category' => '',
        ], [
            'email.required' => 'El campo Correo electronico es obligatorio',
            'email.email' => 'El campo Correo electronico debe tener el formato: ejemplo@correo.com',
            'phone.required' => 'El campo Teléfono es obligatorio',
        ]);

        $mailer->send(new LeadUserRequest($message));

        SendLeadUser::dispatch(
            LeadUser::createFromLead(
                $message['email'],
                $message['phone'],
                $message['name'],
                (isset($message['category'])) ? $message['category'] : '',
            )
        );

        return response()->json(['result' => 'success']);
    }
}
