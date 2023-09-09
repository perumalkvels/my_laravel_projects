<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthMiddleware
{
    
    public function handle($request, Closure $next)
    {
        // Perform common operations or checks for all routes
        return $next($request);
    }
    
    public function login($request)
    {
        $username = $request->input('uname');
        $password = $request->input('password');
        Log::warning('This is from middleware');
        
        if (empty($username) || empty($password)) {
            return response()->json(['message' => 'Username and password are required.'], 400);
        }

        // Perform any additional authentication or request modification logic here
        
        return $request;
    }
    public function logout($request){
        $uid = $request->input('id');
        if (empty($uid)){
            return response()->json(['message' => 'Some Problem Occurs.'], 400);
        }
        return $request;
    }
    public function register($request){
        $uname = $request->input('uname');
        $password = $request->input('password');
        $confirmpassword = $request->input('confirmpassword');
        $mobile = $request->input('mobile');
        if (empty($uname)){
            return response()->json(['message' => 'Required Username.'], 400);
        }
        else if($password===$confirmpassword){
            return response()->json(['message' => 'Please ReEnter Correct Password'], 400);
        }
        else if(mb_strlen($mobile)==10){
            return response()->json(['message' => 'Please Enter a Valid MobileNo'], 400);
        }
        return $request;
    }
    public function resetPassword($request){
        $password = $request->input('password');
        $confirmpassword = $request->input('confirmpassword');
        if($password===$confirmpassword){
            return response()->json(['message' => 'Please ReEnter Correct Password'], 400);
        }
        return $request;
    }
}


