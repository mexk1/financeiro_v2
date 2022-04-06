<?php

namespace Tests\Feature\Account\Api;

use App\Models\Account;
use App\Models\User;
use App\Services\CRUD\Account\DesactivateAccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DesactivateAccountTest extends TestCase
{
    use DatabaseMigrations;

    protected Account $account;
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->createOne();
    }

    public function test_desactivate_account_service(){
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

    public function test_can_desactivate_account_api(){
        Sanctum::actingAs(
            $this->account->owner,
            [ '*', "desactivate_account" ]
        );
        $account = $this->account;
        $response = $this->deleteJson( route( "api.accounts.desactivate", compact( 'account' )));
        $response->assertOk();
        $this->assertDatabaseHas( Account::class, [
            'id' => $account->id,
            ['deleted_at', '<>', null ]
        ] );
    }

}
