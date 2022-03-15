<?php

namespace App\Services\CRUD\BankAccount;

use App\Models\Account;
use App\Models\BankAccount;
use App\Services\CRUD\CRUDService;

class CreateBankAccountService extends  CRUDService{

    protected array $data;
    protected Account $account;

    public function __construct( array $data, Account $account ){
        $this->data = $data;
        $this->account = $account;
    }

    public function run(){
        $bank_account = new BankAccount( $this->data );

        if( !$this->account->bank_accounts()->save( $bank_account ) ) return false;

        return $bank_account->refresh();
    }
}
