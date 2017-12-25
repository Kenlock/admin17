<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\DimsavRequest;
use App\Models\Dimsav;
use Table;

class DimsavController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->view .= 'modules.dimsav.';
        $this->model = new Dimsav();
    }

    public function getData()
    {
        $model = $this->model->datatablesTranslations();

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
            'model' => new Dimsav(),
        ]);
    }

    public function postCreate(DimsavRequest $request)
    {
        return $this->create($this->model, $request->all());
    }

    public function getUpdate($id)
    {
        $model = $this->model->findOrFail($id);
        return $this->makeView('_form', [
            'model' => $model,
        ]);
    }

    public function postUpdate(DimsavRequest $request, $id)
    {
        $this->model = $this->model->findOrFail($id);
        return $this->update($this->model, $request->all());
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
