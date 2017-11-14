<?php namespace App\Models\Repository;

use App\Models\Menu;

class MenuRepository
{
	public $menu;

	public function __construct()
	{
		$this->menu = new Menu();
	}

	public function parents()
	{
		$model = $this->menu
			->where('parent_slug',null)
			->get();

		return $model;
	}
}