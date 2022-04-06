<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReadAccountsTest extends TestCase
{
    use DatabaseMigrations;

    protected Account $account;
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->createOne();
    }

    public function test_can_list_accounts(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', 'list_accounts' ]
        );
        $response = $this->getJson( route("api.accounts.list") );
        $response->assertOk();
    }

    public function test_can_read_account(){
        Sanctum::actingAs(
            $this->account->owner,
            [ '*', 'retriev_account' ]
        );

        $account = $this->account;
        $response = $this->getJson( route( "api.accounts.read", compact( 'account' )));
        $response->assertOk();
        $response->assertJson( function( AssertableJson $json ){
            $json->whereAll( [
                "id" => $this->account->id,
                "name" => $this->account->name,
            ])->etc();
        });
    }

}
