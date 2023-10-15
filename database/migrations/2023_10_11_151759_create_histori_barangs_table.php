<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('barang_id');
            $table->string('nama_barang');
            $table->string('jumlah');
            $table->string('harga_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histori_barangs');
    }
}
