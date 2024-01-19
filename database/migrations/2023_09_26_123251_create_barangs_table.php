<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('suplier_id')->index();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('harga_jual');
            $table->string('harga_beli');
            $table->string('stok_barang');
            $table->timestamps();

            $table->foreign('suplier_id')->references('id')->on('supliers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
