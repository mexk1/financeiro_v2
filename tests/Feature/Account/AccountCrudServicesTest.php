<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\User;
use App\Services\CRUD\Account\CreateAccountService;
use App\Services\CRUD\Account\DesactivateAccountService;
use App\Services\CRUD\Account\UpdateAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AccountCrudServicesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_account(){

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

    public function test_update_account(){
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

    public function test_desactivate_account(){
        $account = Account::factory()->createOne();
        $service = new DesactivateAccountService( $account );
        $result = $service->run();
        $this->assertNotFalse( $result );
        $this->assertNotNull( $result->deleted_at );
        $this->assertNotNull( $account->deleted_at );
        $this->assertDatabaseHas( Account::class, [
            'id' => $account->id,
            ['deleted_at', '<>', null ]
        ] );

    }

}
