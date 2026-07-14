<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function test_user_can_register_with_correct_values(): void
    {
        $response =  $this->from('es/registro')->json('POST', route('registro'), [
            'name' => 'pepito',
            'email' => 'test@mail.com',
            'phone' => '666666666',
            'password' => 'i-love-laravel',
            'terms' => 1
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => 'test@mail.com']);
    }
}
