<?php

namespace Tests\Feature\BankAccount;

use App\Models\BankAccount;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BankAccountBalanceTest extends TestCase
{
    use DatabaseMigrations;

    protected BankAccount $bank_account;
    protected float $billion = 1000000000.00;

    protected function setUp(): void{
        parent::setUp();
        $this->bank_account = BankAccount::factory()->createOne();
    }

    public function test_can_receive_1_billion()
    {
        $this->bank_account->update([
            "balance" => $this->billion
        ]);
        $this->assertDatabaseHas( BankAccount::class ,[
            "id" => $this->bank_account->id,
            "balance" => $this->billion
        ]);
    }

    public function test_can_have_negative_1_billion()
    {
        $this->bank_account->update([
            "balance" => -$this->billion
        ]);
        $this->assertDatabaseHas( BankAccount::class ,[
            "id" => $this->bank_account->id,
            "balance" => -$this->billion
        ]);
    }
}
