<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor as Model;

class Visitor
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
        $model = new Model();
        $model->saveOrUpdate();
        return $next($request);
    }
}
