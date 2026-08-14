<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;

class ImageController extends Controller
{
    public function imageUpload(Request $request, CdnAdapter $cdnAdapter): JsonResponse
    {
        $user = \App\User::where("id", Auth::id())->first();
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $name = time() . $file->getClientOriginalName();
            $filePath = 'images/users/' . $name;

            if ($cdnAdapter->upload($filePath, $file)) {
                $user->avatar = $filePath;
                $user->save();
            }

            return response()->json($user);
        }
        return response()->json(['status' => 'error',
            'errors' => 'Image empty'
        ], 422);
    }
}
