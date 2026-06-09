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
        Schema::create('tattoo_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('artist_id')->constrained('users')->cascadeOnDelete();
            $table->json('reference_images')->nullable();
            $table->text('idea')->nullable();
            $table->string('size')->nullable();
            $table->string('placement')->nullable();
            $table->json('days')->nullable();
            $table->string('time_preference')->nullable();
            $table->string('budget')->nullable();
            $table->string('age_confirm')->nullable();
            $table->string('pronouns')->nullable();
            $table->text('timeframe')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tattoo_requests');
    }
};
