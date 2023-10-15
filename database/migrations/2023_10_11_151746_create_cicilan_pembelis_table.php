<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicilanPembelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cicilan_pembelis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('penjualanbarang_id')->index();
            $table->string('urutan_cicilan');
            $table->string('jumlah_uang');
            $table->timestamps();

            $table->foreign('penjualanbarang_id')->references('id')->on('penjualan_barangs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cicilan_pembelis');
    }
}
