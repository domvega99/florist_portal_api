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
        Schema::create('florists', function (Blueprint $table) {
            $table->id();
            $table->string('floristcode', 10);
            $table->unsignedInteger('status');
            $table->string('floristname', 255);
            $table->string('contactnumber', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->unsignedInteger('province')->nullable();
            $table->string('website', 100)->nullable();
            $table->string('socialmedia', 100)->nullable();
            $table->string('shopifygid', 150)->nullable();
            $table->unsignedInteger('floristinfo')->nullable();
            $table->unsignedInteger('floristrep')->nullable();
            $table->binary('photo')->nullable();
            $table->string('photo_url', 500)->nullable();
            $table->unsignedInteger('collection')->nullable();
            $table->unsignedInteger('imported')->nullable();
            $table->unsignedInteger('infoid')->nullable();
            $table->unsignedInteger('user')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('florists');
    }
};
