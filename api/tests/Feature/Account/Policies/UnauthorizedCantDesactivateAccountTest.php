<?php

namespace Tests\Feature\Account\Policies;

class UnauthorizedCantDesactivateAccountTest extends AbstractAccountPoliciesTest
{
    public function test_unauthenticated_cant_desactivate_account(){
        $account = $this->account;
        $response = $this->deleteJson(route('api.accounts.desactivate', compact('account') ));
        $response->assertUnauthorized();
    }
}
