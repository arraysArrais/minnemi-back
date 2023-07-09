<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            //Access token from the request        
            $token = JWTAuth::parseToken();        
            //Try authenticating user       
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {        //Thrown if token has expired        
            return $this->unauthorized('Your token has expired. Please, login again.');
        } catch (TokenInvalidException $e) {        //Thrown if token invalid
            return $this->unauthorized('Your token is invalid. Please, login again.');
        } catch (JWTException $e) {        //Thrown if token was not found in the request.
            return $this->unauthorized('Please, attach a Bearer Token to your request');
        }    //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        if($user && $user->role === 'admin'){
            return $next($request);
        }

        return $this->unauthorized();
    }

    private function unauthorized()
    {
        return response()->json([
            'message' => 'You are unauthorized to access this resource',
        ], 401);
    }
}
