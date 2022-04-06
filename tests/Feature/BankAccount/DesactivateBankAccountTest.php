<?php

namespace Tests\Feature\BankAccount;

use App\Models\Account;
use App\Models\BankAccount;
use App\Services\CRUD\BankAccount\DesactivateBankAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DesactivateBankAccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_desactivate_bank_account_service(){
        $bank_account = BankAccount::factory()->createOne();
        $service = new DesactivateBankAccountService( $bank_account );
        $bank_account = $service->run();
        $this->assertNotFalse( $bank_account );
        $this->assertNotNull( $bank_account->deleted_at );
        $this->assertDatabaseHas( BankAccount::class, [
            'id' => $bank_account->id,
            ['deleted_at', '<>', null ]
        ] );
    }


    public function test_desactivate_bank_account_api(){

        $account = Account::factory()->createOne();

        Sanctum::actingAs(
            $account->owner,
            [ '*', 'bank_accounts.desactivate' ]
        );

        /**
         * @var \App\Models\BankAccount $bank_account
         */
        $bank_account = BankAccount::factory()->makeOne();
        $bank_account->account()->associate( $account );
        $bank_account->save();

        $uri =  route( "api.bank-accounts.desactivate", compact( 'bank_account' ) );
        $response = $this->deleteJson( $uri );
        $response->assertOk();
        $this->assertDatabaseHas( BankAccount::class, [
            'id' => $bank_account->id,
            ['deleted_at', '<>', null ]
        ]);
    }

}
