<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Setting;
use Admin;

class SettingMetaController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->view.='setting.';
    	$this->model=new Setting();
    	$this->group='setting_meta';
    }

    public function metas()
    {
    	return [
    		'description',
    		'keywords',
    		'author',
    		'viewport',
    	];
    }

    public function getIndex()
    {
    	$setting = setting()->byGroup($this->group);

    	return $this->makeView('meta',[
    		'model'=>$this->model,
    		'metas'=>$this->metas(),
    		'setting'=>$setting,
    	]);
    }

    public function postIndex(Request $request)
    {
    	$this->model->whereGroup($this->group)->delete();
    	$data=[];
    	foreach($this->metas() as $meta)
    	{
    		$data[]=[
    			'group'=>$this->group,
    			'key'=>$meta,
    			'value'=>$request->{$meta},
    		];
    	}

    	$this->model->insert($data);

    	return redirect(urlBackendAction('index'))
    		->with('success','data has been updated');		
    }
}
