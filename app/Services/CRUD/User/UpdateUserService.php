<?php

namespace App\Services\CRUD\User;

use App\Models\User;
use App\Services\CRUD\CRUDService;

class UpdateUserService extends  CRUDService{

    protected User $user;
    protected array $data;

    public function __construct( User $user, array $data ){
        $this->data = $data;
        $this->user = $user;
    }

    public function run(){
        if( !$this->user->update( $this->data ) ) return false;
        return $this->user->refresh();
    }
}
