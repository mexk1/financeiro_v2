<?php

namespace App\Services\CRUD\User;

use App\Models\User;
use App\Services\CRUD\CRUDService;

class CreateUserService extends  CRUDService{

    protected array $data;

    public function __construct( array $data ){
        $this->data = $data;
    }

    public function run(){
        $user = new User( $this->data );
        if( !$user->save() ) return false;
        return  $user;
    }
}
