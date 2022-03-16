<?php

namespace Tests\Feature\Account\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_unauthorized_cant_create_account(){
        $response = $this->postJson( "api/accounts" );
        $response->assertUnauthorized();
    }

    public function test_create_account()
    {
        $user = User::factory()->createOne();
        Sanctum::actingAs(
            $user,
            [ '*', "create_account" ]
        );

        $payload = [
            'name' => "Test Account"
        ];
        $response = $this->postJson("api/accounts", $payload );
        $response->assertStatus(201);
        $this->assertDatabaseHas( Account::class, $payload );
        $user_account = $user->ownedAccounts()
            ->where('name', $payload["name"])
            ->where('owner_id', $user->id )
            ->first();
        $this->assertNotNull( $user_account );
    }

    public function test_missing_params_cant_create_account()
    {
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "create_account" ]
        );
        $payload = [ ];
        $response = $this->postJson("api/accounts", $payload );
        $response->assertStatus(422);
        $response->assertJson( function( AssertableJson $json ){
            $json->has('errors')
                 ->has("errors.name")
                 ->etc();
        });
    }

}
