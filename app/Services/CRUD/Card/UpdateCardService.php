<?php

namespace App\Services\CRUD\Card;

use App\Models\Card;
use App\Services\CRUD\CRUDService;

class UpdateCardService extends  CRUDService{

    protected Card $card;
    protected array $data;
    public function __construct( Card $card, array $data  ){
        $this->card = $card;
        $this->data = $data;
    }

    public function run(){
        if( !$this->card->update( $this->data ) ) return false;

        return $this->card->refresh();
    }
}
