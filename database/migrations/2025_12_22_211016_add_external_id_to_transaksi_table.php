<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('transaksi', function (Blueprint $table) {
        $table->string('external_id')->nullable()->after('id_user'); // Sesuaikan 'id_user' dengan kolom yang ada
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('transaksi', function (Blueprint $table) {
        $table->dropColumn('external_id');
    });
}
};
