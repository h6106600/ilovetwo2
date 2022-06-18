<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_data', function (Blueprint $table) {
     
            $table->bigIncrements('id');
            $table->string('phone')->unique();//手機號(帳號)
            $table->string('username')->unique();//暱稱
            $table->string('identity');//身分證(密碼)
            $table->string('gender');//性別
            $table->string('consultant');//顧問
            $table->string('data_url');//資料連結
            $table->string('data_url_simple')->nullable();//資料連結刪減版
            $table->string('plan')->nullable();//方案別
            $table->string('live_place')->nullable();//居住地
            $table->string('birth_place')->nullable();//出身地
            $table->string('for_light_plan')->nullable();//輕方案會員能看到
            $table->string('record')->nullable();//紀錄
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
        Schema::dropIfExists('date_data');
    }
}
