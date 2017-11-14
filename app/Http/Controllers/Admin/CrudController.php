<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Crud;
use Admin;
use Table;
use Image;

class CrudController extends AdminController
{
    public function __construct()
	{
		parent::__construct();
		$this->view.='example.crud.';
		$this->model = new Crud();
	}

	public function getIndex()
    {
    	dd($this->model);
    	//return $this->makeView('index');
    }
}
