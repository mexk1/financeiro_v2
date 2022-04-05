<?php

namespace Tests\Feature\Account\PaymentMethods;

use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BankAccountDebitCardPaymentMethodTest extends TestCase
{
    use DatabaseMigrations;

    protected User $owner;
    protected User $member;
    protected Account $account;
    protected BankAccount $bank_account;

    protected Card $card;
    protected string $url;

    protected function setUp(): void
    {
        parent::setUp();

        parent::setUp();
        /**
         * @var \App\Models\User
         */
        $this->owner = User::factory()->createOne();
        $this->account = $this->owner->ownedAccounts()->save( Account::factory()->makeOne( ) );

        $this->bank_account = BankAccount::factory()->makeOne();
        $this->account->bank_accounts()->save( $this->bank_account );

        $this->card = Card::factory()->makeOne([ "mode" => "debit"  ] );
        $this->bank_account->cards()->save( $this->card );

        $this->url = route('api.accounts.paymentMethods', [ 'account' => $this->account ]);

        Sanctum::actingAs( $this->owner, [
            '*', 'accounts.paymentMethods'
        ] );
    }

    public function test_bank_account_card_mode_debit_payment_method_listing(){

        $methods = $this->account->payment_methods;

        $this->assertEquals( 2, count( $methods ) );
        $this->assertEquals([
            [ "origin" => "bank_account", "mode" => "debit", "reference_id" => $this->bank_account->id  ],
            [ "origin" => "card", "mode" => "debit", "reference_id" => $this->card->id ],
        ], $methods );
    }

    public function test_bank_account_card_mode_debit_payment_method_api_listing(){

        $response = $this->getJson( $this->url );
        $response->assertStatus( 200 );
        $response->assertJson( function( AssertableJson $json ) {
            return $json
                ->has( "0", function( AssertableJson $json){
                    return $json->where( "origin", "bank_account" )
                        ->where("mode", "debit")
                        ->where("reference_id", $this->bank_account->id );
                })
                ->has( "1", function( AssertableJson $json) {
                    return $json->where( "origin", "card" )
                        ->where("mode", "debit")
                        ->where("reference_id", $this->card->id );
                })->etc();
        });
    }
}
