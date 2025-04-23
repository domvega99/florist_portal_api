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
            $table->text('call_outcome')->nullable();
            $table->string('product_type', 255)->nullable();
            $table->string('product_price', 50)->nullable();
            $table->string('delivery_fee', 50)->nullable();
            $table->enum('sell_extras', ['Yes', 'No'])->nullable();
            $table->string('popularity_trend')->nullable();
            $table->enum('preferred_communication', ['Facebook', 'Email', 'Phone', 'Other'])->nullable();
            $table->text('member_of_other_networks')->nullable();
            $table->text('flower_supplier')->nullable();
            $table->enum('interested_in_free_website', ['Yes', 'No', 'Maybe'])->nullable();
            $table->string('discount_offer', 255)->nullable();
            $table->text('additional_info')->nullable();
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('page_title', 255)->nullable();
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
