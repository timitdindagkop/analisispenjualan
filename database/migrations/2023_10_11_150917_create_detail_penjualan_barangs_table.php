<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualan_barangs', function (Blueprint $table) {
            $table->id();
            $table->uuid('penjualanbarang_id')->index();
            $table->uuid('barang_id')->index();
            $table->string('jumlah');
            $table->string('harga');
            $table->string('status_cicilan')->default('tidak');
            $table->string('jumlah_cicilan')->default(0);
            $table->string('dp_cicilan')->default(0);
            $table->timestamps();

            $table->foreign('penjualanbarang_id')->references('id')->on('penjualan_barangs')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penjualan_barangs');
    }
}
