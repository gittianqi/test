<?php

namespace App\Http\Middleware;

use App\Service\UserService;
use Closure;
use tests\Mockery\Adapter\Phpunit\EmptyTestCase;

class UserAuth
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
        if ($request->session()->has('adminUser'))
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
