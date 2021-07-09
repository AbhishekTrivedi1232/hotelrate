<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $primaryKey = 'rate_id';
    public $timestamps = false;
    public $table = 'rates';
    protected $fillable=[
        'hotel_id','from_date','to_date',"rate_for_adult","rate_for_child"
    ];
}
