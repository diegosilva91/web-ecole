<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    //use RefreshDatabase;
    //use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

       //Artisan::call('migrate');
    }

    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(301);
    }

    public function testHome()
    {
        $response = $this->get('/es');

        $response->assertStatus(200);
    }

    public function testCo()
    {
        $response = $this->get('/es');

        $response->assertStatus(200);
    }

    public function tearDown(): void
    {
     //   $this->artisan('migrate:reset');
    }
}
