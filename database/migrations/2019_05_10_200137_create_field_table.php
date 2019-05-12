<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->VARCHAR(20)('szarufa');
            $table->VARCHAR(20)('ereszvonal');
            $table->VARCHAR(20)('emeletek');
            $table->VARCHAR(20)('tavolsag');
            $table->VARCHAR(20)('elakontyolason');
            $table->VARCHAR(20)('gerincvonal');
            $table->VARCHAR(20)('gerincvonal2');
            $table->VARCHAR(20)('kontyeresz');
            $table->VARCHAR(20)('ereszrovid');            
            $table->VARCHAR(20)('eresz3');
            $table->VARCHAR(20)('eresz4');
            $table->VARCHAR(20)('eresz5');
            $table->VARCHAR(20)('falszegolemez');     
            $table->VARCHAR(20)('falszegolemez2');        
            $table->VARCHAR(20)('vapa');
            $table->VARCHAR(20)('kontyel');
            $table->VARCHAR(20)('el');
            $table->VARCHAR(20)('orom');
            $table->INTEGER('roofId');
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
        Schema::dropIfExists('field');
    }
}
