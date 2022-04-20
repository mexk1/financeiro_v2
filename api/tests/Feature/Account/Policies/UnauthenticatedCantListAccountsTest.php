<?php

namespace Tests\Feature\Account\Policies;

class UnauthenticatedCantListAccountsTest extends AbstractAccountPoliciesTest
{
    public function test_unauthenticated_cant_list_accounts(){
        $response = $this->getJson( route('api.accounts.list') );
        $response->assertUnauthorized();
    }
}
