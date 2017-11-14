<?php namespace Admin;

use Illuminate\Support\ServiceProvider;

use Admin\Admin;

class AdminProvider extends ServiceProvider
{
	public function boot()
	{

	}

	public function register()
	{
		return  $this->app->bind('register-admin',function(){
			return new Admin();
		});
	}
}