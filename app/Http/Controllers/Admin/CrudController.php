<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Crud;
use Illuminate\Http\Request;
use Table;
use App\Http\Requests\Admin\CrudRequest;

class CrudController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->view .= 'modules.crud.';
        $this->model = new Crud();
    }

    public function getData()
    {
        $model = $this->model->select('id', 'title', 'order', 'status')
            ->orderBy('order', 'asc');

        return Table::of($model)
            ->addColumn('action', function ($model) {
                $hidden = \Form::hidden('id[]', $model->id);
                return $hidden . admin()->html->linkActions($model);
            })
            ->make(true);
    }

    public function getIndex()
    {
        return $this->makeView('index');
    }

    public function getCreate()
    {
        return $this->makeView('_form', [
            'model' => new Crud(),
        ]);
    }

    public function postCreate(CrudRequest $request)
    {
        $inputs          = $request->all();
        $inputs['image'] = $this->handleUpload($request, $this->model, 'image', [1903, 446]);
        return $this->create($this->model, $inputs);
    }

    public function getUpdate($id)
    {
        $model = $this->model->findOrFail($id);
        return $this->makeView('_form', [
            'model' => $model,
        ]);
    }

    public function postUpdate(CrudRequest $request, $id)
    {
        $this->model     = $this->model->findOrFail($id);
        $inputs          = $request->all();
        $inputs['image'] = $this->handleUpload($request, $this->model, 'image', [1903, 446]);
        return $this->update($this->model, $inputs);
    }

    public function getUpdateOrder()
    {
        return $this->update_order($this->model);
    }

    public function getDelete($id)
    {
        return $this->delete($this->model->findOrFail($id));
    }

    public function getActionBool($id)
    {
        return $this->publish_draft($this->model->findOrFail($id));

    }
}
