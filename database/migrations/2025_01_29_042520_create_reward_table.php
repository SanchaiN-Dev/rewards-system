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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('title'); // Reward title
            $table->text('description'); // Reward description
            $table->integer('points_required'); // Points required to redeem the reward
            $table->string('image'); // Image URL
            $table->date('valid_until')->nullable(); // Expiration date
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
