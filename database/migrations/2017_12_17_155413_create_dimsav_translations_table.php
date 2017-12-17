<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimsavTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimsav_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dimsav_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('locale')->index();
            $table->foreign('dimsav_id')
                ->on('dimsavs')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('dimsav_translations');
    }
}
