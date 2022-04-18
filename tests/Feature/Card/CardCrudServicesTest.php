<?php

namespace Tests\Feature\Card;

use App\Models\Card;
use App\Services\CRUD\Card\CreateCardService;
use App\Services\CRUD\Card\DesactivateCardService;
use App\Services\CRUD\Card\UpdateCardService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CardCrudServicesTest extends TestCase
{
    use DatabaseMigrations;


    public function test_update_card(){
        $card = Card::factory()->createOne();

        $data = [
            'name' => 'Test - edited',
            'limit' => 100,
            "mode" => "both"
        ];
        $service = new UpdateCardService( $card, $data );

        $result = $service->run();
        foreach( $data as $prop => $value )
            $this->assertEquals( $result->{$prop}, $value );

        $data = array_merge(['id' => $card->id,], $data );
        $this->assertDatabaseHas( Card::class, $data );
    }

    public function test_desactivate_card(){
        $card = Card::factory()->createOne();
        $service = new DesactivateCardService( $card );
        $result = $service->run();
        $this->assertNotFalse( $result );
        $this->assertNotNull( $result->deleted_at );
        $this->assertNotNull( $card->deleted_at );
        $this->assertDatabaseHas( Card::class, [
            'id' => $card->id,
            ['deleted_at', '<>', null ]
        ] );

    }
}
