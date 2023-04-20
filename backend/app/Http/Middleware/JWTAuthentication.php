<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as ExceptionsTokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
class JWTAuthentication
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
    try {
      $user = JWTAuth::parseToken()->authenticate();
    } catch (\Exception $e) {
      if ($e instanceof TokenExpiredException) {
        return response()->json(['success' => 'false', 'message' => 'Token Expired'], 401);
      } else if ($e instanceof ExceptionsTokenInvalidException) {
        return response()->json(['success' => 'false', 'message' => 'Token Invalid'], 401);
      } else {
        return response()->json(['success' => 'false', 'message' => 'Token Not Found'], 401);
      }
    }
    return $next($request);
  }
}