<?php

namespace App\Services\CRUD\Card;

use App\Models\BankAccount;
use App\Models\Card;
use App\Services\CRUD\CRUDService;

class CreateCardService extends  CRUDService{

    protected array $data;
    protected BankAccount $account;

    public function __construct( array $data, BankAccount $account ){
        $this->data = $data;
        $this->account = $account;
    }

    public function run(){
        $card = new Card( $this->data );
        if( !$this->account->cards()->save( $card ) ) return false;
        return $card->refresh();
    }
}
