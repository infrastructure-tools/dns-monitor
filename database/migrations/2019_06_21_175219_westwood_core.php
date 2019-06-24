<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WestwoodCore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hostname');
            $table->integer('flags');
            $table->timestamps();
        });

        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('host_id');
            $table->text('data');
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
        Schema::drop('hosts');
        Schema::drop('records');
    }
}
