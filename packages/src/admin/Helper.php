<?php

function assetAdmin($path)
{
	return asset('admin/'.$path);
}

function routeController($slug,$class)
{
	return \RouteController::build($slug,$class);
}

function admin()
{
	$class=new \Admin\Admin;
	return $class;
}

function urlBackendAction($action)
{
	return admin()->urlBackendAction($action);
}

function carbon()
{
	return new \Carbon\Carbon;
}

function parse($parse)
{
	return carbon()->parse($parse);
}

function ip_info($ip)
{
	$url = "http://ip-api.com/json/".$ip;
	$contents = file_get_contents($url);
	$array = json_decode($contents);
	return $array;    
}

function setting()
{
	return new \App\Models\Setting();
}

function getId()
{
	return \Admin::getId();
}