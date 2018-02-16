<?php

function assetAdmin($path)
{
    return asset('admin/' . $path);
}

function routeController($slug, $class)
{
    return \RouteController::build($slug, $class);
}

function admin()
{
    $class = new \Admin\Admin;
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
    $url      = "http://ip-api.com/json/" . $ip;
    $contents = file_get_contents($url);
    $array    = json_decode($contents);
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

function languages()
{
    return config('admin.languages');
}

function langKeys()
{
    $res = [];
    foreach (languages() as $key => $val) {
        $res[] = $key;
    }
    return $res;
}

function ruleTrans($fields)
{
    $result = [];

    foreach (langKeys() as $lang) {
        foreach ($fields as $field => $rules) {
            $result[$lang . '.' . $field] = $rules;
        }
    }

    return $result;
}

function isJson($string)
{
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

function lang()
{
    $languages = langKeys();

    $lang = app()->getLocale();

    if(in_array($lang,$languages))
    {
        return $lang;
    }else{
        return config('admin.default_language');
    }

}
