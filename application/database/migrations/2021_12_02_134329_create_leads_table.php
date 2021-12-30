<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('tags')->nullable();
            $table->string('field_search')->nullable();
            $table->integer('lead_id')->nullable();
            $table->integer('responsible_user_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('pipeline_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
