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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('kode_promo')->unique();
            $table->string('nama_promo');
            $table->enum('tipe', ['persen', 'nominal']);
            $table->decimal('nilai', 12, 2);
            $table->decimal('minimal_belanja', 12, 2)->nullable();
            $table->decimal('maksimal_diskon', 12, 2)->nullable();
            $table->dateTime('mulai');
            $table->dateTime('berakhir');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
