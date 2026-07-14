<?php

namespace App\Http\Controllers\Api\Teachers;

use App\Http\Controllers\Controller;
use App\Jobs\SendLeadTeacher;
use App\Mail\Internal\LeadTeacherRequest;
use App\Mail\WelcomeTeacher;
use Illuminate\Http\Request;
use Lifecole\Api\Domain\DTO\LeadTeacher;
use Lifecole\Shared\Domain\Repository\Mailer;

class LandingRequestController extends Controller
{
    public function landingRequest(Request $request, Mailer $mailer)
    {
        $message = request()->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
            'category' => '',
        ], [
            'email.required' => 'El campo Correo electronico es obligatorio',
            'email.email' => 'El campo Correo electronico debe tener el formato: ejemplo@correo.com',
            'phone.required' => 'El campo Teléfono es obligatorio',
            'name.required' => 'El campo Nombre es obligatorio',
        ]);

        $mailer->send(new LeadTeacherRequest($message));

        $mailer->send(new WelcomeTeacher($message['email'], $message['name']));

        SendLeadTeacher::dispatch(
            LeadTeacher::createFromLead(
                $message['email'],
                $message['phone'],
                $message['name'],
                ($message['category'] !== null) ? $message['category'] : '',
            )
        );

        return response()->json(['result' => 'success']);
    }
}
