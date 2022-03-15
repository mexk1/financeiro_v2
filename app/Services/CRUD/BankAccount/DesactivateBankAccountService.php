<?php

namespace App\Services\CRUD\BankAccount;

use App\Models\BankAccount;
use App\Services\CRUD\CRUDService;

class DesactivateBankAccountService extends  CRUDService{

    protected BankAccount $bank_account;

    public function __construct( BankAccount $bank_account ){
        $this->bank_account = $bank_account;
    }

    public function run(){
        if( !$this->bank_account->delete() ) return false;
        return $this->bank_account->refresh();
    }
}
