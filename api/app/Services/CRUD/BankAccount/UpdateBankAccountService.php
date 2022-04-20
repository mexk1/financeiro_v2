<?php

namespace App\Services\CRUD\BankAccount;

use App\Models\BankAccount;
use App\Services\CRUD\CRUDService;

class UpdateBankAccountService extends  CRUDService{

    protected BankAccount $account;
    protected array $data;
    public function __construct( BankAccount $account, array $data  ){
        $this->account = $account;
        $this->data = $data;
    }

    public function run(){
        if( !$this->account->update( $this->data ) ) return false;

        return $this->account->refresh();
    }
}
