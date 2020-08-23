<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('statistic_date')->index()->comment('统计时间');
            $table->integer('confirm')->nullable()->comment('累计确诊');
            $table->integer('confirm_add')->nullable()->comment('当日新增确诊');
            $table->integer('suspect')->nullable()->comment('累计疑似');
            $table->integer('suspect_add')->nullable()->comment('当日新增疑似');
            $table->integer('heal')->nullable()->comment('累计治愈');
            $table->integer('heal_add')->nullable()->comment('当日新增治愈');
            $table->integer('dead')->nullable()->comment('累计死亡');
            $table->integer('dead_add')->nullable()->comment('当日新增死亡');
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
        Schema::dropIfExists('history_statistics');
    }
}
