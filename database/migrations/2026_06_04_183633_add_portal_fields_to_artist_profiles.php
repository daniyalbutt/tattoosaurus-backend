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
        Schema::table('artist_profiles', function (Blueprint $table) {
            $table->json('social_links')->nullable();      // {facebook, instagram, ...}
            $table->string('availability')->nullable();     // e.g. "Mon-Fri 9-5"
            $table->string('response_time')->nullable();    // e.g. "Responds within 2 days"
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->json('faqs')->nullable();               // [{q, a}, ...]
            $table->json('styles')->nullable();             // ["fineline","dotwork","illustrative"]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artist_profiles', function (Blueprint $table) {
            //
        });
    }
};
