<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            \App\User::create([
                'role_id'=>1,
                'username'=>'admin',
                'email'=>'admin@admin.com',
                'name'=>'Administrator',
                'password'=>\Hash::make('password'),
                'avatar'=>'user.png',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $model=\DB::table('users')
                ->where('username','admin')
                ->first();
            if(isset($model))
            {
                $model->delete();
            }

        });
    }
}
