<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('floristsinfo', function (Blueprint $table) {
            $table->id();
            $table->text('call_outcome');
            $table->string('product_type', 255);
            $table->string('product_price', 50);
            $table->string('delivery_fee', 50);
            $table->string('sell_extras', 10);
            $table->text('popularity_trend');
            $table->string('preferred_communication', 255);
            $table->text('member_of_other_networks');
            $table->text('flower_supplier');
            $table->string('interested_in_free_website', 255);
            $table->string('discount_offer', 255);
            $table->text('additional_info');
            $table->text('description');
            $table->text('meta_description');
            $table->string('page_title', 255);
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floristsinfo');
    }
};
