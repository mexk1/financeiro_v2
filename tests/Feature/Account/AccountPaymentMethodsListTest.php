<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccountPaymentMethodsListTest extends TestCase
{
    use DatabaseMigrations;
    protected User $owner;
    protected User $member;
    protected Account $account;
    protected BankAccount $bank_account;
    protected string $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createOwner();
        $this->createMember();
        $this->createAccount();
        $this->createBankAccount();

        $this->url = "/api/accounts/{$this->account->id}/payment-methods";
    }

    public function test_unauthenticated_user_cant_list_payment_methods(){
        $response = $this->getJson( $this->url );
        $response->assertStatus(401);
    }

    public function test_not_account_member_cant_list_payment_methods(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "read_payment_methods" ]
        );
        $response = $this->getJson( $this->url );
        $response->assertStatus(403);
    }

    public function test_account_debit_payment_method_listing(){
        $methods = $this->account->payment_methods;
        $this->assertEquals( 1, count( $methods ) );
        $this->assertEquals([[
            "origin" => "bank_account",
            "mode" => "debit",
            "reference_id" => $this->bank_account->id
        ]], $methods );
    }

    public function test_account_debit_payment_method_api_listing(){
        $response = $this->asOwner()->getJson( $this->url );
        $response->assertStatus( 200 );
        $response->assertJson( function( AssertableJson $json ){
            return $json->has( 1 )
                ->first( function( AssertableJson $json){
                    return $json->where( "origin", "account" )
                        ->where("mode", "debit");
                });
        });
    }

    public function test_account_card_mode_debit_payment_method_listing(){
        $card = $this->bank_account
            ->cards()
            ->save( Card::factory()->makeOne([ "mode" => "both"  ] ) );

        $methods = $this->account->payment_methods;

        $this->assertEquals( 2, count( $methods ) );
        $this->assertEquals([
            [ "origin" => "bank_account", "mode" => "debit", "reference_id" => $this->bank_account->id  ],
            [ "origin" => "card", "mode" => "debit", "reference_id" => $card->id ],
        ], $methods );
    }

    public function test_account_card_mode_debit_payment_method_api_listing(){
        $card = $this->bank_account
            ->cards()
            ->save( Card::factory()->makeOne([ "mode" => "both"  ] ) );

        $response = $this->asOwner()->getJson( $this->url );
        $response->assertStatus( 200 );
        $response->assertJson( function( AssertableJson $json ) use ( $card ) {
            return $json
                ->has( "0", function( AssertableJson $json){
                    return $json->where( "origin", "bank_account" )
                        ->where("mode", "debit")
                        ->where("reference_id", $this->bank_account->id );
                })
                ->has( "0", function( AssertableJson $json) use ( $card ) {
                    return $json->where( "origin", "bank_account" )
                        ->where("mode", "debit")
                        ->where("reference_id", $card->id );
                })->etc();
        });
    }

    public function test_all_account_payment_methods_listing(){
        $this->bank_account->cards()->saveMany([
            Card::factory()->makeOne([ "mode" => "both"  ] ),
            Card::factory()->makeOne([ "mode" => "credit"] ),
            Card::factory()->makeOne([ "mode" => "debit" ] ),
        ]);
        $methods = $this->account->payment_methods;
        /**
         * method 1 account debit
         * method 2 card mode debit debit
         * method 3 card mode credit credit
         * method 4 card mode both debit
         * method 5 card mode both credit
         */
        $this->assertEquals( count( $methods ), 5 );
    }

    private function asOwner(){
        Sanctum::actingAs(
            $this->owner,
            [ '*', "read_payment_methods" ]
        );
        return $this;
    }

    private function createOwner(){
        $this->owner = User::factory()->create();
    }

    private function createMember(){
        $this->member = User::factory()->create();
    }

    private function createAccount(){
        $this->account = Account::factory()->makeOne();
        $this->account->owner()->associate( $this->owner );
        $this->account->save();
        $this->account->users()->attach( $this->member );
    }

    private function createBankAccount(){
        $this->bank_account = $this->account->bank_accounts()->save( BankAccount::factory()->make() );
    }

}
