<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proxy_id');
            $table->integer('code');
            $table->string('mac')->comment('设备号');
            $table->string('status')->comment('机器状态');
            $table->unsignedInteger('surplus')->comment('剩余纸巾');
            $table->unsignedInteger('quantity')->comment('总量');
            $table->unsignedInteger('out')->comment('出纸总数');
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
        Schema::dropIfExists('papers');
    }
}
