<?php

namespace Tests\Feature\Account\PaymentMethods;

use App\Models\Account;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BankAccountDebitPaymentMethodTest extends TestCase
{
    use DatabaseMigrations;


    protected User $owner;
    protected User $member;
    protected Account $account;
    protected BankAccount $bank_account;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var \App\Models\User
         */
        $this->owner = User::factory()->createOne();
        $this->account = $this->owner->accounts()->save( Account::factory()->makeOne( ) );

        $this->bank_account = BankAccount::factory()->makeOne();
        $this->account->bank_accounts()->save( $this->bank_account );

        $this->url = route('api.accounts.paymentMethods', [ 'account' => $this->account ]);

        Sanctum::actingAs( $this->owner, [
            '*', 'accounts.paymentMethods'
        ] );
    }

    public function test_bank_account_debit_payment_method_listing(){
        $methods = $this->account->payment_methods;
        $this->assertEquals( 1, count( $methods ) );
        $this->assertEquals([[
            "origin" => "bank_account",
            "mode" => "debit",
            "reference_id" => $this->bank_account->id
        ]], $methods );
    }

    public function test_bank_account_debit_payment_method_api_listing(){
        $response = $this->getJson( route('api.accounts.paymentMethods', [ 'account' => $this->account ] ) );
        $response->assertStatus( 200 );
        $response->assertJson( function( AssertableJson $json ){
            return $json->has( 1 )
                ->first( function( AssertableJson $json){
                    return $json->where( "origin", "bank_account" )
                        ->where("mode", "debit")
                        ->etc();
                });
        });
    }
}
