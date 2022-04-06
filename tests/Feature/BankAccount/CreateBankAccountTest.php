<?php

namespace Tests\Feature\BankAccount;

use App\Models\Account;
use App\Models\BankAccount;
use App\Services\CRUD\BankAccount\CreateBankAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateBankAccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_bank_account_service(){
        $data = [  "name" => "Test account" ];

        $account = Account::factory()->createOne();

        $service = new CreateBankAccountService( $data, $account );
        $bank_account = $service->run();

        $this->assertNotFalse( $bank_account );
        $this->assertEquals( $bank_account->balance, 0 );
        $this->assertDatabaseHas( BankAccount::class, [
            "id" => $bank_account->id,
            "name" => $data["name"],
            "account_id" => $account->id,
            "balance" => 0
        ]);
    }

    public function test_create_bank_account_api(){

        $account = Account::factory()->createOne();

        Sanctum::actingAs(
            $account->owner,
            [ '*', 'bank_accounts.create' ]
        );

        $bank_account = BankAccount::factory()->makeOne();

        $uri =  route( "api.accounts.bank-accounts.create", compact( 'account' ) );
        $response = $this->postJson( $uri, $bank_account->toArray() );
        $response->assertCreated();
        $response->assertJson( function( AssertableJson $json ) use ( $bank_account ) {
            return $json->has('id')
                ->where( 'name', $bank_account->name )
                ->etc();
        });
    }
}
