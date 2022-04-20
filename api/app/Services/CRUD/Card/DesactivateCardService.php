<?php

namespace App\Services\CRUD\Card;

use App\Models\Card;
use App\Services\CRUD\CRUDService;

class DesactivateCardService extends  CRUDService{

    protected Card $card;

    public function __construct( Card $card ){
        $this->card = $card;
    }

    public function run(){
        if( !$this->card->delete() ) return false;
        return $this->card->refresh();
    }
}
