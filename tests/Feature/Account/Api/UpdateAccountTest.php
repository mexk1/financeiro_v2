<?php

namespace Tests\Feature\Account\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateAccountTest extends TestCase
{
    use DatabaseMigrations;

    protected Account $account;
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->createOne();
    }

    public function test_can_update_account(){
        Sanctum::actingAs(
            $this->account->owner,
            [ '*', "update_account" ]
        );
        $payload = [
            "name" => "Test Account edited"
        ];
        $response = $this->patchJson("api/accounts/{$this->account->id}", $payload );
        $response->assertOk();
        $this->assertDatabaseHas( Account::class, [
            "name" => $payload["name"],
            "id" => $this->account->id
        ]);
    }

    public function test_unauthenticated_cant_update_account(){
        $response = $this->patchJson("api/accounts/{$this->account->id}");
        $response->assertUnauthorized();
    }

    public function test_not_owner_cant_update_account(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "update_account" ]
        );
        $response = $this->patchJson("api/accounts/{$this->account->id}");
        $response->assertForbidden();
    }

    public function test_missing_params_cant_update_account()
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
