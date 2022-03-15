<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AttachUserToAccountTest extends TestCase
{

    use DatabaseMigrations;

    public function test_attach_account_to_user(){
        /**
         * @var \App\Models\Account
         */
        $account = Account::factory()->createOne();
        $user = User::factory()->createOne();
        $account->users()->attach( $user );
        $this->assertDatabaseHas( "user_account", [
            "user_id" => $user->id,
            "account_id" => $account->id
        ] );
    }
}
