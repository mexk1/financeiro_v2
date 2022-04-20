<?php

namespace Tests\Feature\Account\Policies;

use App\Models\Account;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

abstract class AbstractAccountPoliciesTest extends TestCase
{

    use DatabaseMigrations;

    protected Account $account;
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->createOne();
    }

}
