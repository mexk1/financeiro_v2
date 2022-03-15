<?php

namespace Tests\Feature\User;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AttachAccountToUserTest extends TestCase
{

    use DatabaseMigrations;

    public function test_attach_account_to_user(){
        /**
         * @var \App\Models\User
         */
        $user = User::factory()->createOne();
        $account = Account::factory()->createOne();
        $user->accounts()->attach( $account );
        $this->assertDatabaseHas( "user_account", [
            "user_id" => $user->id,
            "account_id" => $account->id
        ] );
    }
}
