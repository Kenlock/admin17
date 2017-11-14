<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Admin;
use Table;
use Image;

class UserController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->view.='user_administration.user.';
		$this->model = new User();
	}

	public function getData()
    {
    	$model = $this->model->select('users.id','email','username','name','roles.role')
    		->join('roles','roles.id','=','users.role_id')
    		->where('users.id','!=',auth()->user()->id);

    	if(auth()->user()->role->id != 1)
    	{
    		$model=$model->where('roles.id','!=',1);
    	}

		return	Table::of($model)
	    		->addColumn('action',function($model){
	    			return admin()->html->linkActions($model);
	    		})
	    		->make(true);
	}

	public function getIndex()
    {
    	return $this->makeView('index');
    }

    public function getCreate()
	{
		return $this->makeView('_form',[
			'model'=>$this->model,
		]);
	}

	public function postCreate(Requests\Admin\UserRequest $request)
	{
		$inputs = $request->all();
		$inputs['avatar']=$this->handleUpload($request,$this->model,'avatar',[100,100]);
		$inputs['password']=\Hash::make($request->password);
		return $this->create($this->model,$inputs);
	}

	public function getUpdate($id)
	{
		return $this->makeView('_form',[
			'model'=>$this->model->findOrFail($id),
		]);
	}

	public function postUpdate(Requests\Admin\UserRequest $request,$id)
	{
		$model = $this->model->findOrFail($id);
		$inputs = $request->all();
		$inputs['avatar']=$this->handleUpload($request,$model,'avatar',[100,100]);
		$inputs['password']=\Hash::make($request->password);
		return $this->update($model,$inputs);
	}

	public function getDelete($id)
    {
    	if($id == 1)
    	{
    		return $this->redirectActionInfo('This data cannot be deleted!');
    	}
    	$model=$this->model->findOrFail($id);
    	return $this->delete($model,[$model->avatar]);
    }

}
