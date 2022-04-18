<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "bank_account_id",
        "last_digits",
        "mode",
        "bill_close_day",
        "limit",
    ];

    public function bank_account(){
        return $this->belongsTo( BankAccount::class );
    }
}
