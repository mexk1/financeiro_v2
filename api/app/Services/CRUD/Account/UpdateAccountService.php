<?php

namespace App\Services\CRUD\Account;

use App\Models\Account;
use App\Services\CRUD\CRUDService;

class UpdateAccountService extends  CRUDService{

    protected Account $account;
    protected array $data;
    public function __construct( Account $account, array $data  ){
        $this->account = $account;
        $this->data = $data;
    }

    public function run(){
        if( !$this->account->update( $this->data ) ) return false;

        return $this->account->refresh();
    }
}
