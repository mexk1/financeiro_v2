<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\User;
use App\Services\CRUD\Account\CreateAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_account_service(){

        $data = [
            "name" => "tester",
        ];
        $owner = User::factory()->createOne();

        $service = new CreateAccountService( $data, $owner );
        $result = $service->run();

        $data["owner"] = $owner;
        foreach( $data as $prop=> $value )
            $this->assertEquals( $result->{$prop}, $value );

        unset( $data["owner"] );
        $data["owner_id"] = $owner->id;

        $this->assertDatabaseHas( Account::class, $data );
    }

    public function test_create_account_api()
    {
        $user = User::factory()->createOne();
        Sanctum::actingAs(
            $user,
            [ '*', "accounts.create" ]
        );

        $payload = [
            'name' => "Test Account"
        ];
        $response = $this->postJson( route( "api.accounts.create" ), $payload );
        $response->assertStatus(201);
        $this->assertDatabaseHas( Account::class, $payload );
        $user_account = $user->ownedAccounts()
            ->where('name', $payload["name"])
            ->where('owner_id', $user->id )
            ->first();
        $this->assertNotNull( $user_account );
    }

}
