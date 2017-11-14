<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class MediaLibraryController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->view.='media_library.';
	}

	public function getIndex()
	{
		return $this->makeView('index');
	}
}
