<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Admin;
use Image;

class ProfileController extends AdminController
{
    public function __construct()
    {
    	parent::__construct();
    	$this->model=new User();
    	$this->view.="user_administration.";
    }

    public function getIndex()
    {
    	$model=$this->model->findOrFail(auth()->user()->id);

    	return $this->makeView('profile',[
    		'model'=>$model,
    	]);
    }

    public function cekOldPassword($password)
    {
        $result=false;
        if(\Hash::check($password,auth()->user()->password))
        {
            $result=true;
        }
        return $result;
    }

    public function postIndex(Requests\Admin\ProfileRequest $request)
    {
       $cek=$this->cekOldPassword($request->old_password);
       if($cek==true)
       {
        $model = $this->model->findOrFail(auth()->user()->id);
        $inputs = $request->all();
        $inputs['avatar']=$this->handleUpload($request,$model,'avatar',[100,100]);
        $inputs['password']=\Hash::make($request->password);
        return $this->update($model,$inputs);
       }else{
        return $this->redirectActionDanger('Your Old Password is Wrong!!');
       }
    }
}
