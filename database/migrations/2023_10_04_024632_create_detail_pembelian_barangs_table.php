<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembelianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelian_barangs', function (Blueprint $table) {
            $table->id();
            $table->uuid('pembelianbarang_id')->index();
            $table->uuid('barang_id')->index();
            $table->string('jumlah');
            $table->string('harga');
            $table->string('total_harga');
            $table->timestamps();

            $table->foreign('pembelianbarang_id')->references('id')->on('pembelian_barangs')->onDelete('cascade');
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
        Schema::dropIfExists('detail_pembelian_barangs');
    }
}
