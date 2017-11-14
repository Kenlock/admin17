<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->index();
            $table->string('parent_slug')->nullable();
            $table->string('label');
            $table->string('controller')->index();
            $table->integer('order');
            $table->enum('is_active',['true','false']);
            $table->timestamps();

            // $table->foreign('parent_slug')
            //     ->references('slug')
            //     ->on('menus')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
