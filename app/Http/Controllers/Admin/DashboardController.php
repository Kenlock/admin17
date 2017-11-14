<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Visitor;
use Admin;
use Table;

class DashboardController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->view.='dashboard.';
        $this->model = new Visitor();
	}

    public function getData()
    {
        $model = $this->model->select('id','ip','clicks','information','country','city','created_at')
            ->orderBy('created_at','desc');
        return  Table::of($model)->make(true);
    }

    public function lastSevenDays()
    {
        $now = parse(date("Ymd"));
        
        $start_date=$now->addDays(-7);
        
        $result=[];
        $no=0;
        for($date=$start_date;$date->lte(parse(date("Ymd")))>0;$date->addDays(1))
        {
            $result[]=$date->format("d M Y");
        }

        return  collect($result);
    }

    public function getDataLastSevenDays()
    {
        $data=[];

        foreach($this->lastSevenDays() as $row)
        {
            $date=parse($row);
            $model=Visitor::select('id')
                ->whereDay($date->year,$date->month,$date->day)
                ->count();
            $data[]=$model;
        }

        return collect($data);
    }

    public function getIndex()
    {
        return $this->makeView('index',[
            'categories'=> $this->lastSevenDays()->toJson(),
            'data'=> $this->getDataLastSevenDays()->toJson(),
        ]);
    }
}
