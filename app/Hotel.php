<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $primaryKey = 'hotel_id';
    public $timestamps = false;
    public $table = 'hotels';
    protected $fillable=[
        'hotel_name','hotel_start','hotel_address'
    ];
}
