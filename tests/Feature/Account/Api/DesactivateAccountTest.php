<?php

namespace Tests\Feature\Account\Api;

use App\Models\Account;
use App\Models\User;
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

    public function test_can_desactivate_account(){
        Sanctum::actingAs(
            $this->account->owner,
            [ '*', "desactivate_account" ]
        );
        $response = $this->deleteJson("api/accounts/{$this->account->id}");
        $response->assertOk();
    }

    public function test_unauthenticated_cant_desactivate_account(){
        $response = $this->deleteJson("api/accounts/{$this->account->id}");
        $response->assertUnauthorized();
    }

    public function test_not_owner_cant_desactivate_account(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "desactivate_account" ]
        );
        $response = $this->deleteJson("api/accounts/{$this->account->id}");
        $response->assertForbidden();
    }

}
