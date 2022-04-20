<?php

namespace Tests\Feature\Card;

use App\Models\Card;
use App\Services\CRUD\Card\DesactivateCardService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;

class DeleteCardTest extends AbstractWithExistingCardContext
{
    use DatabaseMigrations;

    public function test_delete_card_service(){

        $card = $this->card;
        $service = new DesactivateCardService( $card );
        $result = $service->run();
        $this->assertNotFalse( $result );
        $this->assertNotNull( $result->deleted_at );
        $this->assertDatabaseHas( Card::class, [
            'id' => $card->id,
            ['deleted_at', '<>', null ]
        ] );
    }

    public function test_delete_card_api(){

        $card = $this->card;

        Sanctum::actingAs(
            $card->bank_account->account->owner,
            [ '*', 'cards.desactivate' ]
        );

        $data = $card->toArray();
        $data['name'] = uniqid('name_');

        $uri =  route( "api.cards.desactivate", compact( 'card' ) );
        $response = $this->deleteJson( $uri );
        $response->assertOk();
        $this->assertDatabaseHas( Card::class, [
            'id' => $card->id,
            ['deleted_at', '<>', null ]
        ]);
    }
}
