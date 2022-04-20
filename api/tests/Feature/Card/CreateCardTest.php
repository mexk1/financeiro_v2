<?php

namespace Tests\Feature\Card;

use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Card;
use App\Services\CRUD\Card\CreateCardService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCardTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_card_service(){

        $data = [
            "last_digits" => "1234",
            "name" => "tester",
            "bill_close_day" => 10,
            'limit' => 100,
        ];
        $bank_account = BankAccount::factory()->createOne();

        $service = new CreateCardService( $data, $bank_account );
        $result = $service->run();

        foreach( $data as $prop=> $value )
            $this->assertEquals( $result->{$prop}, $value );

        $this->assertDatabaseHas( Card::class, $data );
    }

    public function test_create_card_api(){

        $card = Card::factory()->makeOne();
        $bank_account = $card->bank_account;
        Sanctum::actingAs(
            $bank_account->account->owner,
            [ '*', 'cards.create' ]
        );

        $uri =  route( "api.bank-accounts.cards.create", compact( 'bank_account' ) );
        $response = $this->postJson( $uri, $card->toArray() );
        $response->assertCreated();
        $response->assertJson( function( AssertableJson $json ) use ( $card ) {
            return $json->has('id')
                ->where( 'name', $card->name )
                ->etc();
        });
    }
}
