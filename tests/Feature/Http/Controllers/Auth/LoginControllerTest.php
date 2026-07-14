<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        try {
            $this->user = User::create([
                'name' => 'Nombre',
                /*'last_name' => 'Apellido',*/
                'email' => 'test@mail.com',
                'password' => bcrypt('i-love-laravel'),//Hash::make ( $data[ 'password' ] ),
                'avatar' => 'images/users/default.png'
            ]);
        } catch (\Exception $e) {
            $this->user = User::where('email', 'test@mail.com')->first();
        }
    }

    public function test_user_can_login_with_correct_password(): void
    {
        $response =  $this->from('es/login')->call('POST', route('login'), [
            'email' => 'test@mail.com',
            'password' => 'i-love-laravel'
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => 'test@mail.com']);
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $response =  $this->from('es/login')->call('POST', route('login'), [
            'email' => 'badUsername@gmail.com',
            'password' => 'badPass'
        ]);
        $response->assertStatus(401);
        $this->assertGuest();
    }

    public function tearDown(): void
    {
        if (isset($this->user)) {
            try {
                $this->user->delete();
            } catch (\Exception $e) {
                $user = User::find('test@mail.com');
                $user->delete();
            }
        }
        //   $this->artisan('migrate:reset');
    }
}
