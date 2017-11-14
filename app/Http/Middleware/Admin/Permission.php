<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Admin;
use App\Models\Permission as Model;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Admin::getUser();
        $model = new Model();
        $statusPermission = $model->roleHasPermissionThisMethod();
        if($statusPermission == 'method_found' || $statusPermission == 'method_not_protected')
        {
            return $next($request);
        }else{
            abort(401);
        }
    }
}
