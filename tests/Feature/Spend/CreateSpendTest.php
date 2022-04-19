<?php

namespace Tests\Feature\Spend;

use App\Models\Account;
use App\Models\Spend;
use App\Services\CRUD\Spend\CreateSpendService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateSpendTest extends TestCase
{

    use DatabaseMigrations;

    public function test_create_spend_service(){

        $account = Account::factory()->createOne();
        $spend = Spend::factory()->makeOne();

        $data = $spend->toArray();
        $service = new CreateSpendService( $account, $spend->toArray() );

        $result = $service->run();

        $check = [
            'value',
            'description'
        ];

        foreach( $check as $prop ){
            $this->assertEquals( $data[$prop], $result->{$prop} );
            $check[$prop] = $data[$prop];
        }

        $this->assertDatabaseHas( Spend::class, [
            'id' => $result->id,
            'value' => $data['value']
        ] );

    }

    public function test_create_spend_api(){

        $spend = Spend::factory()->makeOne();

        $account = Account::factory()->createOne();
        Sanctum::actingAs(
            $account->owner,
            [ '*', 'spends.create' ]
        );

        $uri =  route( "api.accounts.spends.create", compact( 'account' ) );
        $response = $this->postJson( $uri, $spend->toArray() );
        $response->assertCreated();
        $response->assertJson( function( AssertableJson $json ) use ( $spend ) {
            return $json->has('id')
                ->etc();
        });


    }
}
