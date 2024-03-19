<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pembeli_id')->index();
            $table->string('tanggal');
            $table->string('total_barang');
            $table->string('total_uang');
            $table->string('status_cicilan')->default('tidak');
            $table->string('status_bayar');
            $table->string('dp_cicilan')->default(0);
            $table->timestamps();

            $table->foreign('pembeli_id')->references('id')->on('pembelis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_barangs');
    }
}
