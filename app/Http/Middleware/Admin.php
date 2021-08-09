<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(DB::table('role_user')
            ->where('user_id', $request->user()->id)
            ->where('role_id', UserType::Administrator)
            ->where('status', AccountStatus::Active)
            ->exists() || DB::table('role_user')
            ->where('user_id', $request->user()->id)
            ->where('role_id', UserType::Seller)
            ->where('status', AccountStatus::Active)
            ->exists()){
                return $next($request);
        }
        return back();
    }
}
