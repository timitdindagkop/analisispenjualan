<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('suplier_id')->index();
            $table->string('tanggal');
            $table->string('total_barang');
            $table->string('total_uang');
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
        Schema::dropIfExists('pembelian_barangs');
    }
}
