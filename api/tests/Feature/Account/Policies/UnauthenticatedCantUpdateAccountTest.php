<?php

namespace Tests\Feature\Account\Policies;

class UnauthenticatedCantUpdateAccountTest extends AbstractAccountPoliciesTest
{
    public function test_unauthenticated_cant_update_account(){
        $account = $this->account;
        $response = $this->patchJson(route('api.accounts.update', compact('account') ));
        $response->assertUnauthorized();
    }
}
