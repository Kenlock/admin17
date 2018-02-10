<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Crud;
use Table;
use Illuminate\Http\Request;

class ScaffoldingController extends AdminController
{
    use \Admin\Scaffolding;

    public function __construct()
    {
        parent::__construct();
    }

    public function model()
    {
        return new Crud();
    }

    /* Sample Manipulate DataTable Fields

    public function table_fields()
    {
        return [
            'headers' => [
                'Title',
                'Action',
            ],
            'records' => [
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false],
            ],
        ];
    }

    */

    /* Sampe Manipulate Query Datatables

    public function query_data_tables()
    {
        $model = $this->model()->select('id', 'title', 'order', 'status')
            ->orderBy('order', 'asc');

        return Table::of($model)
            ->addColumn('action', function ($model) {
                return 'tupak_sakurse';
            })
            ->make(true);
    }
    */
    public function form()
    {
        return [
            'title' => [
                'label'      => 'Title',
                'type'       => 'text',
                'attributes'=>[
                    'class'=>'form-control',
                ],
                'validation'=>[
                    'rules'=>'required|min:3|unique:cruds,title,'.getId(),
                ],
            ],
        ];
    }
    /*
    
    Sample Manipulate Form
    
    public function form()
    {
        return [
            'title' => [
                'label'      => 'Title',
                'type'       => 'text',
                'value' =>'This Value',
                'attributes'=>[
                    'class'=>'form-control',
                ],
                'validation'=>[
                    'rules'=>'required|email|min:3',
                    'messages'=>['title.required'=>'reqiored','title.email'=>'emailna']
                ],
            ],
            'description' => [
                'label'      => 'Title',
                'type'       => 'textarea',
                'value' =>'This TextArea',
                'attributes'=>[
                    'class'=>'form-control ckeditor',
                ],
            ],
            'gender' => [
                'type'       => 'select',
                'label'      => 'Status',
                'attributes' => [
                    'class'=>'select2'
                ],
                'data'       => ['L' => 'Laki Laki', 'W'=>'Wanita'],
            ],
            'image' => [
                'label'      => 'Image',
                'type'       => 'image',
                'attributes'=>[
                    'image_name'=>'';
                ],
            ],
            'status'=>[
                'type'=>'status',
            ],
        ];
    }
    
    */    

}
