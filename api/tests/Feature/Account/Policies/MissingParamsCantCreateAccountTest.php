<?php

namespace Tests\Feature\Account\Policies;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MissingParamsCantCreateAccountTest extends AbstractAccountPoliciesTest
{

    public function test_missing_params_cant_create_account()
    {
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "accounts.create" ]
        );
        $payload = [ ];
        $response = $this->postJson( route( "api.accounts.create" ), $payload );
        $response->assertStatus(422);
        $response->assertJson( function( AssertableJson $json ){
            $json->has('errors')
                 ->has("errors.name")
                 ->etc();
        });
    }

}
