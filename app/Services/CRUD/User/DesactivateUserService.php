<?php

namespace App\Services\CRUD\User;

use App\Models\User;
use App\Services\CRUD\CRUDService;

class DesactivateUserService extends  CRUDService{

    protected User $user;

    public function __construct( User $user ){
        $this->user = $user;
    }

    public function run(){
        if( !$this->user->delete() ) return false;
        return $this->user->refresh();
    }
}
