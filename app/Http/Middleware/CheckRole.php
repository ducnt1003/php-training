<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $token = strtok($role, ";");
        while ($token !== false) {
            if ($request->user()->hasRole($token)){
                return $next($request);
            }
            $token = strtok(";");
        }
        $response = ['error' => 'This action is access denied!'];

        return response()->json([$response])->setStatusCode(403);
    }
}
