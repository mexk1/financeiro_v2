<?php

namespace App\Services\CRUD\Spend;

use App\Models\Account;
use App\Models\Spend;
use App\Services\CRUD\CRUDService;

class CreateSpendService extends CRUDService{

    protected Account $account;
    protected array $data = [];

    public function __construct( Account $account, array $data ){
        $this->account = $account;
        $this->data = $data;
    }

    public function run(){
        $spend = new Spend( $this->data );
        return $this->account->spends()->save( $spend );
    }
}
