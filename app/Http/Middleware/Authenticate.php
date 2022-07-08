<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if(is_null($request->header('authorization'))){
            return response()->json(401, 'authorization failed, without authorization');
        };
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if(! $user){
                return response()->json(401, 'user does not exist');
            }
        }catch (TokenInvalidException $exception) {
            // /return $exception;
            return response()->json([
                'response' => 'Invalid Token',
            ])->setStatusCode(401);
        }
        catch (TokenExpiredException $exception) {
            return response()->json([
                'response' => 'Expired Token',
            ])->setStatusCode(401);
        }catch(JWTException $exception){
            return $exception;
        };

        $this->authenticate($request, $guards);

        return $next($request);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
