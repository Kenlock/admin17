<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Agent;

class Visitor extends Model
{
    protected $guarded=[];

    public function grabInformation()
    {
    	$data=[
    		'Device'=>Agent::device(),
    		'Browser'=>Agent::browser(),
    		'OS'=>Agent::platform(),
    	];
    	return collect($data);

    }

    public function grabIpInfo($ip)
    {
    	//$url="http://ip-api.com/json/208.80.152.201";
    	$url="http://ip-api.com/json/$ip";
    	$content = file_get_contents($url);
    	$obj = json_decode($content);

    	if($obj->status=='fail')
    	{
    		$result=[
    			'country'=>'Indonesia',
    			'city'=>'Jakarta',
    		];
    	}else{
    		$result=[
    			'country'=>$obj->country,
    			'city'=>$obj->city,
    		];
    	}

    	return (object)$result;
    }

    public function scopeWhereDay($query,$year="",$month="",$day="")
    {
        $year=!empty($year)?$year:date("Y");
        $month=!empty($month)?$month:date("m");
        $day=!empty($day)?$day:date("d");
        return $query->whereRaw("YEAR(created_at)=$year")
                ->whereRaw("MONTH(created_at)=$month")
                ->whereRaw("DAY(created_at)=$day");
    }

    public function saveOrUpdate()
    {
    	$ip = request()->getClientIp();
        if($ip!='127.0.0.1')
        {
        	$ipInfo=$this->grabIpInfo($ip);
        	$model=$this->where('ip',$ip)
        		->whereDay()
        		->first();

        	
        	$data = [
        		'ip'=>$ip,
        		'clicks'=>@$model->clicks + 1,
        		'information'=>$this->grabInformation()->toJson(),
        		'country'=>$ipInfo->country,
        		'city'=>$ipInfo->city,
        	];
        	
        	if(!empty($model->id))
        	{
        		$model->update($data);
        	}else{
        		$this->create($data);
        	}

        }    	
    }
}
