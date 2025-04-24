<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Florist extends Model
{
    use HasFactory;

    protected $table = 'florists';

    protected $fillable = [
        'florist_name',
        'contact_number',
        'address',
        'city',
        'postcode',
        'delivery_fee',
        'sell_extras',
    ];

    public $timestamps = false;
}
