<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pushes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identity');
            $table->string('pushes_user')->nullable();
            $table->string('pushes_user_new')->nullable();
            $table->string('pushes_user_latest')->nullable();
            $table->string('pushes_user_excluded')->nullable();
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
        Schema::dropIfExists('pushes');
    }
}
