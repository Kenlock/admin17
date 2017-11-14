<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Setting;
use Admin;

class SettingGeneralController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->view.='setting.';
    	$this->model=new Setting();
    	$this->group='setting_general';
    }

    public function getIndex()
    {
        $setting = $this->model->byGroup($this->group);
        return $this->makeView('general',[
            'model'=>$this->model,
            'setting'=>$setting,
        ]);
    }

    public function toArray($inputs)
    {
        unset($inputs['_token']);
        $data=[];

        foreach($inputs as $key => $val)
        {
            $data[]=[
                'key'=>$key,
                'value'=>$val,
                'group'=>$this->group,
            ];
        }

        return $data;
    }

    public function postIndex(Request $request)
    {
        $this->validate($request,['logo'=>'image']);

        $inputs = $request->all();
        
        $this->model->deleteGroup($this->group);

        $this->model->insert($this->toArray($inputs));

        return $this->redirectActionSuccess();    
    }
}
