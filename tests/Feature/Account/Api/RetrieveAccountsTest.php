<?php

namespace Tests\Feature\Account\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RetrieveAccountsTest extends TestCase
{
    use DatabaseMigrations;

    protected Account $account;
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->createOne();
    }

    public function test_unauthenticated_cant_list_accounts(){
        $response = $this->getJson('api/accounts');
        $response->assertUnauthorized();
    }

    public function test_unauthenticated_cant_retrieve_account(){
        $response = $this->getJson("api/accounts/{$this->account->id}");
        $response->assertUnauthorized();
    }

    public function test_can_list_accounts(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', 'list_accounts' ]
        );
        $response = $this->getJson('api/accounts');
        $response->assertOk();
    }

    public function test_can_retrieve_account(){
        Sanctum::actingAs(
            $this->account->owner,
            [ '*', 'retriev_account' ]
        );
        $response = $this->getJson("api/accounts/{$this->account->id}");
        $response->assertOk();
        $response->assertJson( function( AssertableJson $json ){
            $json->whereAll( [
                "id" => $this->account->id,
                "name" => $this->account->name,
            ])->etc();
        });
    }

}
