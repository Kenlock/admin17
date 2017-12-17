<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\StaticModel;
use Illuminate\Http\Request;

class StaticController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->view .= 'modules.static.';
        $this->model = new StaticModel();
        $this->group = 'example';
    }

    public function getIndex()
    {
        $data = $this->model->getByGroup($this->group);
        return $this->makeView('_form', [
            'model' => $this->model,
            'data'   => $data,
        ]);
    }

    public function postIndex(Request $request)
    {
        $inputs          = $request->all();
        $inputs['image'] = $this->handleUploadStatic($request, 'image', [100, 100]);
        $this->updateStaticPage($inputs,$this->group);
        return $this->redirectActionSuccess('Data has been saved');
    }
}
