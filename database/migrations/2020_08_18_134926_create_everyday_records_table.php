<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEverydayRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('everyday_records', function (Blueprint $table) {
            $table->id();
            $table->dateTime('last_update_time')->comment('最后更新时间');
            $table->string('province')->nullable()->comment('省');
            $table->string('city')->nullable()->comment('市');
            $table->integer('confirm_today')->comment('今日新增确诊');
            $table->integer('confirm_now')->comment('现有确诊');
            $table->integer('confirm_total')->comment('累计确诊');
            $table->integer('suspect_total')->comment('累计疑似');
            $table->integer('dead_total')->comment('累计死亡');
            $table->integer('heal_total')->comment('累计治愈');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('everyday_records');
    }
}
