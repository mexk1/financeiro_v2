<?php

namespace App\Services\CRUD\Account;

use App\Models\Account;
use App\Services\CRUD\CRUDService;

class DesactivateAccountService extends  CRUDService{

    protected Account $account;

    public function __construct( Account $account ){
        $this->account = $account;
    }

    public function run(){
        if( !$this->account->delete() ) return false;
        return $this->account->refresh();
    }
}
