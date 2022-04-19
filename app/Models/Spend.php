<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'description'
    ];


    public function account(){
        return $this->belongsTo( Account::class );
    }
}
