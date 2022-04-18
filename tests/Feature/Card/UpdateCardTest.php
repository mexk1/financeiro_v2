<?php

namespace Tests\Feature\Card;

use App\Models\Card;
use App\Services\CRUD\Card\UpdateCardService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

class UpdateCardTest extends AbstractWithExistingCardContext
{
    use DatabaseMigrations;

    public function test_update_card_service(){

        $card = $this->card;
        $data = $card->toArray();
        $data['name'] = uniqid('name_');
        $service = new UpdateCardService( $card, $data );
        $result = $service->run();


        $check = [
            'name',
            'id'
        ];
        foreach( $check as $prop )
            $this->assertEquals( $result->{$prop}, $data[$prop] );

        $this->assertDatabaseHas( Card::class, $data );
    }

    public function test_update_card_api(){

        $card = $this->card;

        Sanctum::actingAs(
            $card->bank_account->account->owner,
            [ '*', 'cards.update' ]
        );

        $data = $card->toArray();
        $data['name'] = uniqid('name_');

        $uri =  route( "api.cards.update", compact( 'card' ) );
        $response = $this->patchJson( $uri, $data );
        $response->assertOk();
        $response->assertJson( function( AssertableJson $json ) use ( $data ) {
            return $json->has('id')
                ->where( 'name', $data['name'] )
                ->etc();
        });
        $this->assertDatabaseHas( Card::class, [
            'id' => $card->id,
            'name' => $data['name']
        ] );

    }
}
