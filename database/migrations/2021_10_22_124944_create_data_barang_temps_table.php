<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBarangTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_barang_temps', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_barang');
            $table->string('isi_barang');
            $table->integer('qty');
            $table->integer('berat_barang');
            $table->integer('biaya_barang');
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
        Schema::dropIfExists('data_barang_temps');
    }
}
