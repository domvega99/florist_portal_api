<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Florist extends Model
{
    use HasFactory;

    protected $table = 'florists';

    protected $fillable = [
        'floristcode',
        'status',
        'floristname',
        'contactnumber',
        'address',
        'city',
        'postcode',
        'province',
        'website',
        'socialmedia',
        'shopifygid',
        'floristinfo',
        'floristrep',
        'photo',
        'photo_url',
        'collection',
        'imported',
        'infoid',
        'userid',
    ];

    public $timestamps = false;
}
