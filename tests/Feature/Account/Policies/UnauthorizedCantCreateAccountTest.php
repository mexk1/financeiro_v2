<?php

namespace Tests\Feature\Account\Policies;

class UnauthorizedCantCreateAccountTest extends AbstractAccountPoliciesTest
{
    public function test_unauthorized_cant_create_account(){
        $response = $this->postJson( route("api.accounts.create") );
        $response->assertUnauthorized();
    }
}
