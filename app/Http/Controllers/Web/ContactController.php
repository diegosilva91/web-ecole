<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SendLeadUser;
use App\Mail\Internal\ContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Lifecole\Api\Domain\DTO\LeadUser;
use Lifecole\Shared\Domain\Repository\Mailer;
use App\Http\Requests\ContactRequest as ContactRequestForm;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        if (isset($request->teacher_id)) {
            $sender = 'teacher';
            $title = 'Contacta con ';
        } else {
            $sender = 'lifecole';
            $title = 'Contáctanos';
        }
        return view('pages.contact', ['title' => $title, 'sender' => $sender, 'contact_id' => $request->teacher_id]);
    }

    public function contactMail(ContactRequestForm $request, Mailer $mailer): RedirectResponse | JsonResponse
    {
        if (!isset($request->sender) || $request->sender === 'teacher') {
//            $message = request()->validate([
//                'name' => 'required',
//                'email' => 'required|email',
//                'subject' => 'required',
//                'number' => 'required',
//                'category' => 'required',
//                'message' => 'required',
//            ], [
//                'name.required' => 'Nombre es requerido',
//                'email.required' => 'Correo electronico es requerido',
//                'email.email' => 'El email debe ser válido',
//                'subject.required' => 'Debe definir el asunto',
//                'number.required' => 'Debe definir el teléfono',
//                'category.required' => 'Debe definir la categoría',
//                'message.required' => 'Mensaje es requerida',
//            ]);
            $message = $request->all();

            $mailer->send(new ContactRequest($message));

            SendLeadUser::dispatch(
                LeadUser::createFromContact(
                    $message['email'],
                    $message['number'],
                    $message['name'],
                    $message['message'] ?? '',
                    $message['subject'] ?? '',
                )
            );

            if (isset($request->subject) && $request->subject == 'Quiero ser profesor de lifecole') {
                return  $request->wantsJson()
                    ? response()->json('Mensaje enviado correctamente') : back()->with(
                        ['message' => 'Mensaje enviado correctamente', 'lead' => 'leadProfesor']
                    );
            } else {
                return $request->wantsJson()
                    ? response()->json('Mensaje enviado correctamente') : back()->with(
                        ['message' => 'Mensaje enviado correctamente', 'lead' => 'lead']
                    );
            }
        }

        return $request->wantsJson()
            ? response()->json() : back()->withInput();
    }
}
