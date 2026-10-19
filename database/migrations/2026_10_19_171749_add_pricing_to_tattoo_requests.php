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
        Schema::table('tattoo_requests', function (Blueprint $table) {
            $table->decimal('tattoo_price', 10, 2)->nullable()->after('status');   // e.g. 400.00
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('tattoo_price'); // e.g. 100.00
            $table->string('payment_status')->default('deposit_pending')->after('deposit_amount');
            // deposit_pending / deposit_paid / booking_confirmed / balance_pending /
            // balance_paid / fully_paid / payment_failed / refunded
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tattoo_requests', function (Blueprint $table) {
            //
        });
    }
};
