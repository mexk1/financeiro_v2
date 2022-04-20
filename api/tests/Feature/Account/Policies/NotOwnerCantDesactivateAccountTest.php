<?php

namespace Tests\Feature\Account\Policies;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class NotOwnerCantDesactivateAccountTest extends AbstractAccountPoliciesTest
{
    public function test_not_owner_cant_desactivate_account(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "desactivate_account" ]
        );

        $account = $this->account;
        $response = $this->deleteJson( route('api.accounts.desactivate', compact('account')) );
        $response->assertForbidden();
    }
}
