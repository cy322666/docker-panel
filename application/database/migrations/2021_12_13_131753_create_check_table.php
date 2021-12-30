<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('result')->nullable();//успех/неуспех
            $table->string('source_name')->nullable();
            $table->integer('setting_id')->nullable();

            $table->index('result');
            $table->index('created_at');
            $table->index('setting_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check');
    }
}
