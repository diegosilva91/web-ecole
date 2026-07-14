<?php

namespace App\Http\Controllers\Api\Teachers;

use App\Http\Controllers\Controller;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateProfileTeacherController extends Controller
{
    public function update($user_id, Request $request)
    {
        if (Auth::id() == $user_id) {
            $teacher = Teacher::where('user_id', $user_id)->first();
            if (!isset($teacher->user_id)) {
                return response()->json(['error' => 'bad request, the user does not exist'], 401);
            }
            if (isset($request->bio)) {
                $teacher->bio = $request->bio;
            }
            if (isset($request->cv_rrss_url)) {
                $teacher->cv_rrss_url = $request->cv_rrss_url;
            }

            if (isset($request->business_name)) {
                $teacher->business_name = $request->business_name;
            }
            if (isset($request->nif_cif)) {
                $teacher->nif_cif = $request->nif_cif;
            }
            if (isset($request->iban)) {
                $teacher->iban = $request->iban;
            }
            if (isset($request->address)) {
                $teacher->address = $request->address;
            }
            if (isset($request->postal_code)) {
                $teacher->postal_code = $request->postal_code;
            }
            if (isset($request->location)) {
                $teacher->location = $request->location;
            }
            if (isset($request->province)) {
                $teacher->province = $request->province;
            }
            if (isset($request->country)) {
                $teacher->country = $request->country;
            }

            $teacher->save();
            return response()->json($teacher);
        }

        return response()->json(['error' => 'bad request, you must define user_id and user must exist'], 401);
    }
}
