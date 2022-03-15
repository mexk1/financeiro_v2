<?php

namespace Tests\Feature\BankAccount;

use App\Models\Account;
use App\Models\BankAccount;
use App\Services\CRUD\BankAccount\CreateBankAccountService;
use App\Services\CRUD\BankAccount\DesactivateBankAccountService;
use App\Services\CRUD\BankAccount\UpdateBankAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

class BankAccountCrudServicesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_bank_account(){
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

    public function test_update_bank_account(){
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

    public function test_desactivate_bank_account(){
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

}
