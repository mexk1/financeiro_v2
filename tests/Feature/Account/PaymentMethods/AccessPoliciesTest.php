<?php

namespace Tests\Feature\Account\PaymentMethods;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccessPoliciesTest extends TestCase
{
    use DatabaseMigrations;

    protected User $owner;
    protected User $member;
    protected Account $account;
    protected string $url;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var \App\Models\User
         */
        $this->owner = User::factory()->createOne();
        $this->member = User::factory()->createOne();
        $this->account = $this->owner->accounts()->save( Account::factory()->makeOne( ) );

        //"/api/accounts/{$this->account->id}/payment-methods";
        $this->url = route('api.accounts.paymentMethods', [ 'account' => $this->account ]);
    }

    public function test_unauthenticated_user_cant_list_payment_methods(){
        $response = $this->getJson( $this->url );
        $response->assertStatus(401);
    }

    public function test_not_account_member_cant_list_payment_methods(){
        Sanctum::actingAs(
            User::factory()->createOne(),
            [ '*', "read_payment_methods" ]
        );
        $response = $this->getJson( $this->url );
        $response->assertStatus(403);
    }
}
