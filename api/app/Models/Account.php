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
        // file_put_contents( __DIR__ . "/test.json", json_encode( $this->bank_accounts ) );

        $this->bank_accounts->each( function( BankAccount $bank_account ) use ( &$methods ) {
            array_push( $methods, [
                "origin" => "bank_account",
                "mode" => "debit",
                "reference_id" => $bank_account->id
            ]);
            $bank_account->cards()->each( function( Card $card ) use ( &$methods ) {

                if( $card->mode !== "both" ){
                    return array_push( $methods, [
                        "origin" => "card",
                        "mode" =>  $card->mode,
                        "reference_id" => $card->id
                    ]);
                }

                /**
                 * On tests, credit should list first, as the array_push function prepend on array use debit first
                 */
                array_push( $methods, [
                    "origin" => "card",
                    "mode" => "debit",
                    "reference_id" => $card->id
                ]);
                array_push( $methods, [
                    "origin" => "card",
                    "mode" =>  "credit",
                    "reference_id" => $card->id
                ]);
            });
        });

        return $methods;
    }

    public function spends(){
        return $this->hasMany( Spend::class );
    }
}
