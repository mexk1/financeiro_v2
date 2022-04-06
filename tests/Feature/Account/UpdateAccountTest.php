<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\User;
use App\Services\CRUD\Account\UpdateAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateAccountTest extends TestCase
{
    use DatabaseMigrations;

    protected Account $account;
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->createOne();
    }

    public function test_update_account_service(){
        $account = Account::factory()->createOne();

        $data = [
            "name" => "tester2",
        ];
        $service = new UpdateAccountService( $account, $data );

        $result = $service->run();
        foreach( $data as $prop=> $value )
            $this->assertEquals( $result->{$prop}, $value );

        $data = array_merge(['id' => $account->id,], $data );
        $this->assertDatabaseHas( Account::class, $data );
    }

    public function test_can_update_account(){
        Sanctum::actingAs(
            $this->account->owner,
            [ '*', "update_account" ]
        );
        $payload = [
            "name" => "Test Account edited"
        ];

        $account = $this->account;
        $response = $this->patchJson( route('api.accounts.update', compact( 'account' ) ), $payload );
        $response->assertOk();
        $this->assertDatabaseHas( Account::class, [
            "name" => $payload["name"],
            "id" => $this->account->id
        ]);
    }

    /**
     * @todo Move it to Policies
     * @todo Change to named route instead of url
     */
    public function test_missing_params_cant_update_account()
    {
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "create_account" ]
        );
        $payload = [ ];
        $response = $this->postJson("api/accounts", $payload );
        $response->assertStatus(422);
        $response->assertJson( function( AssertableJson $json ){
            $json->has('errors')
                 ->has("errors.name")
                 ->etc();
        });
    }
}
