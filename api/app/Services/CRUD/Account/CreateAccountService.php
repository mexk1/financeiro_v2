<?php

namespace App\Services\CRUD\Account;

use App\Models\Account;
use App\Models\User;
use App\Services\CRUD\CRUDService;

class CreateAccountService extends  CRUDService{

    protected array $data;
    protected User $owner;

    public function __construct( array $data, User $owner ){
        $this->data = $data;
        $this->owner = $owner;
    }

    public function run(){
        $account = new Account( $this->data );
        $account->owner()->associate( $this->owner );
        if( !$account->save() ) return false;

        return $account;
    }
}
