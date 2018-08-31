<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id");
            $table->string("tel")->nullable();
            $table->string("name")->nullable();
            $table->string('card')->nullable();
            $table->string('bank')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('area')->nullable();
            $table->string('power')->nullable();
            $table->string('profit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proxies');
    }
}
