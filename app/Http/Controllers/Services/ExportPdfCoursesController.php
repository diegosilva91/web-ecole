<?php

namespace App\Http\Controllers\Services;

use App\Course;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAssistant;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ExportPdfCoursesController extends Controller
{
    // https://mi-empresa.local/es/courses/complete/export/pdf/121?course_id=231&date=10/10/2021
    public function exportPdfCoursesReceipt(Request $request, $user_id, PDF $pdf)
    {
        if (isset($request->course_id)) {
            if ($request->user_assistant_id) {
                $data['user'] = UserAssistant::find($request->user_assistant_id);
            } else {
                $data['user'] = User::find($user_id);
            }
            $data['course'] = Course::find($request->course_id);
        }
        if (isset($request->date)) {
            $data['date'] = $request->date;
        }
        $data['img'] = 'courses/Services/mail_cert.jpg';
        view()->share('data', $data);
        //$pdf = $pdf->loadView('exports.course_complete_receipt', $data)->setPaper('A4', 'landscape');

        return view('exports.course_complete_receipt', ['data' => $data]);

        // download PDF file with download method
        //return $pdf->download('course_complete.pdf');
    }
}
