<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKalkulacioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kalkulacio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('egyseg');
            $table->decimal('dijegysegre');
            $table->integer('roofId');
            $table->integer('opcionalis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kalkulacio');
    }
}
