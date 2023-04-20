<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoginMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    // kiem tra dang nhap 
    // kiem tra phai la admin khong
    // if(admin){
    //   return $next($request);
    // }else{
    //  return response()->json()
    // }
    // $user = DB::table('users')
    // ->join('role_user', 'users.id', '=', 'role_user.user_id')
    // ->join('roles', 'roles.id', '=', 'role_user.role_id')
    // ->where('users.id',  auth()->user()->id)
    // ->get();
    // if($user[0]->role_name === "admin"){
    //   return $next($request);
    // }else{
    //   return response()->json(['statusCode' => 401, 'message' => 'Unauthorized']);
    // }

    return $next($request);
  }
}
