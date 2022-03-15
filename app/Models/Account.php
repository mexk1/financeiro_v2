<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name"
    ];

    public function users(){
        return $this->belongsToMany( User::class, "user_account" );
    }

    public function owner(){
        return $this->belongsTo( User::class, "owner_id" );
    }

    public function bank_accounts(){
        return $this->hasMany( BankAccount::class );
    }
}
