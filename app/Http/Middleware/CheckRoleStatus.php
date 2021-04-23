<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckRoleStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $author = User::find(Auth::id());
        $session = $author->roles->first()->name;

        $role=Role::where('name', $session)->first();
        if ($role['status']=='inactive') {
            return redirect('/denied');
        }
        return $next($request);
    }
}
