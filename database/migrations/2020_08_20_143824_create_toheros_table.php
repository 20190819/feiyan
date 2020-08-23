<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToherosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toheros', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('姓名');
            $table->string('desc')->nullable()->comment('简介');
            $table->string('img')->nullable()->comment('头像');
            $table->string('area')->nullable()->comment('地区');
            $table->string('sex')->nullable()->comment('性别');
            $table->tinyInteger('age')->nullable()->comment('年龄');
            $table->tinyInteger('type')->nullable()->comment('类型');
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
        Schema::dropIfExists('toheros');
    }
}
