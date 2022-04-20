<?php

namespace Tests\Feature\User\Api;

use App\Events\User\UserCreatedEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    public function test_api_register_user_missing_params_response(){
        $response = $this->postJson( route('api.open.register') , [] );
        $response->assertStatus( 422 );
    }

    public function test_api_register_user_invalid_email_response(){
        $data = [
            "email" => "teste",
            "name" => "Tester",
            "password" => "123456",
            "password_confirmation" => "123456",
        ];
        $response = $this->postJson( route('api.open.register') , $data );
        $response->assertStatus( 422 );
    }

    public function test_api_user_register(){

        Event::fake();
        $data = [
            "email" => "teste@domain.com",
            "name" => "Tester",
            "password" => "123456",
            "password_confirmation" => "123456",
        ];
        $response = $this->postJson( route('api.open.register') , $data );
        $response->assertStatus( 201 );

        unset( $data["password_confirmation"] );

        $this->assertDatabaseHas( User::class, $data );
        Event::assertDispatched( UserCreatedEvent::class );
    }
}
