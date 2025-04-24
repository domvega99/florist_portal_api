<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloristInfo extends Model
{
    use HasFactory;

    protected $table = 'floristsinfo';

    protected $fillable = [
        'call_outcome',
        'product_type',
        'product_price',
        'delivery_fee',
        'sell_extras',
        'popularity_trend',
        'preferred_communication',
        'member_of_other_networks',
        'flower_supplier',
        'interested_in_free_website',
        'discount_offer',
        'additional_info',
        'description',
        'meta_description',
        'page_title',
    ];

    public $timestamps = false;
}
