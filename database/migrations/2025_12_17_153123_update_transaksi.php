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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('status_pengiriman');
            $table->string('kode_promo')->nullable()->after('subtotal');
            $table->decimal('diskon', 10, 2)->default(0)->after('kode_promo');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
