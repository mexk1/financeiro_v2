<?php

namespace Tests\Feature\Account\Policies;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class NotOwnerCantUpdateAccountTest extends AbstractAccountPoliciesTest
{

    public function test_not_owner_cant_update_account(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "update_account" ]
        );

        $account = $this->account;
        $response = $this->patchJson( route('api.accounts.update', compact('account')) );
        $response->assertForbidden();
    }

}
