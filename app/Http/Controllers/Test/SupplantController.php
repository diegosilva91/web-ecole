<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Lifecole\Api\Domain\Adapter\EncryptionAdapter;

class SupplantController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(private EncryptionAdapter $encryptionAdapter)
    {
    }

    public function supplant(string $token)
    {
        $data = $this->encryptionAdapter->decrypt($token);

        $user = User::where(['email' => $data['admin']])->first();
        $this->guard()->login($user);

        return redirect('/es/lf/mis_cursos/' . $data['userId']);
    }
}
