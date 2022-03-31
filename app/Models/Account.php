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

    public function cards(){
        return $this->hasManyThrough(
            Card::class,
            BankAccount::class
        );
    }

    public function getPaymentMethodsAttribute(){
        $methods = [];
        file_put_contents( __DIR__ . "/test.json", json_encode( $this->bank_accounts ) );

        $this->bank_accounts->each( function( BankAccount $bank_account ) use ( &$methods ) {
            array_push( $methods, [
                "origin" => "bank_account",
                "mode" => "debit",
                "reference_id" => $bank_account->id
            ]);
        });

        return $methods;
    }
}
