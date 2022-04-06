<?php

namespace Tests\Feature\BankAccount;

use App\Models\Account;
use App\Models\BankAccount;
use App\Services\CRUD\BankAccount\UpdateBankAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateBankAccountTest extends TestCase
{
    use DatabaseMigrations;


    public function test_update_bank_account_service(){
        $bank_account = BankAccount::factory()->createOne();
        $data = [
            "name" => Str::random( 16 ),
            "balance" => 10.20
        ];
        $service = new UpdateBankAccountService( $bank_account, $data );
        $bank_account = $service->run();
        $this->assertNotFalse( $bank_account );
        $this->assertEquals( $bank_account->name, $data["name"] );
        $this->assertEquals( $bank_account->balance, $data["balance"] );
        $data["id"] = $bank_account->id;
        $this->assertDatabaseHas( BankAccount::class, $data );
    }


    public function test_update_bank_account_api(){

        $account = Account::factory()->createOne();

        Sanctum::actingAs(
            $account->owner,
            [ '*', 'bank_accounts.update' ]
        );

        /**
         * @var \App\Models\BankAccount $bank_account
         */
        $bank_account = BankAccount::factory()->makeOne();
        $bank_account->account()->associate( $account );
        $bank_account->save();

        $data = [  "name" => Hash::make( "Test account" ) ];

        $uri =  route( "api.bank-accounts.update", compact( 'bank_account' ) );
        $response = $this->patchJson( $uri, $data );
        $response->assertOk();
        $response->assertJson( function( AssertableJson $json ) use ( $data ) {
            return $json->has('id')
                ->where('name', $data['name' ] )
                ->etc();
        });
        $this->assertDatabaseHas( BankAccount::class, [
            'id' => $bank_account->id,
            'name' => $data['name']
        ]);
    }
}
