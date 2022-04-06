<?php

namespace Tests\Feature\Account\Policies;

class UnauthenticatedCantReadAccountTest extends AbstractAccountPoliciesTest
{

    public function test_unauthenticated_cant_read_account(){
        $account = $this->account;
        $response = $this->getJson(route('api.accounts.read', compact('account')));
        $response->assertUnauthorized();
    }

}
