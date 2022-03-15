<?php

namespace Tests\Feature\Api\Auth\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserAuthLifeCicleTest extends TestCase
{
    use DatabaseMigrations;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->createOne();
    }

    public function test_unverified_user_cant_login(){
        $user = User::factory()->unverified()->createOne();
        $response = $this->postJson("/api/auth/login", [
            "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertStatus( 422 );
        $response->assertJson( fn( AssertableJson $json ) =>
            $json->has("errors")
                 ->has("errors.email")
                 ->etc()
        );
    }

    public function test_user_wrong_credentials_cant_login(){
        $user = User::factory()->createOne();
        $response = $this->postJson("/api/auth/login", [
            "email" => $user->email,
            "password" => "password123"
        ]);
        $response->assertStatus( 401 );
        $response->assertJson( fn( AssertableJson $json ) =>
            $json->has("errors")
                 ->has("errors.email")
                 ->etc()
        );
    }

    public function test_user_can_login(){
        $user = User::factory()->createOne();
        $response = $this->postJson("/api/auth/login", [
            "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertStatus( 201 );
    }

    public function test_user_can_logout(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*' ]
        );

        $response = $this->get("/api/auth/logout");
        $response->assertOk();
    }

}
