<?php namespace Admin;

use Illuminate\Support\Facades\Facade;

class AdminFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'register-admin';
	}
}