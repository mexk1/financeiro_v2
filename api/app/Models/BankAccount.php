<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "balance"
    ];

    public function account(){
        return $this->belongsTo( Account::class );
    }

    public function cards(){
        return $this->hasMany( Card::class );
    }
}
