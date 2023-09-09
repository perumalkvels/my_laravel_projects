<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $uname = $request->input('uname');
        $password = $request->input('password');
        $user = DB::table('userAuthDetails')->where('uname', $uname)->where('password', $password)->first();
        // $nuser = DB::SELECT("SELECT * FROM  userAuthDetails WHERE uname=? AND password=?",[$uname,$password]);
        // log::warning($nuser);
        log::warning(array($user));
        if ($user) {
            DB::UPDATE("update userAuthDetails SET activeStatus=true WHERE id=?",[$user->id]); 
            $updatedUser = DB::SELECT("SELECT * From userAuthDetails where id=?",[$user->id]);
            return response()->json(['data'=>$updatedUser,'status'=>'success','message' => 'Login successful']);
        }

        return response()->json(['status'=>'failed','message' => 'Invalid username or password'], 401);
    }
    public function register(Request $request)
    {
        $uname = $request->input('uname');
        $password = $request->input('password');
        $mobile = $request->input('confirmpassword');
        $status = DB::INSERT("INSERT INTO userAuthDetails (uname,password,mobileno,activeStatus) VALUES (?, ?, ?, ?)",[
            $uname,
            $password,
            $mobile,
            false,
        ]); 
        if ($status===1) {
            return response()->json(['data'=>$status,'status'=>'success','message' => 'Successfully Registered'],200);
        }

        return response()->json(['status'=>'failed','message' => 'Failed to Register'], 401);
    }
    public function resetPassword(Request $request)
    {   
        $uid = $request->input('id');
        $password = $request->input('password');
        $oldpassword = DB::SELECT("SELECT password From userAuthDetails where id=?",[$uid]); 
        if ($password!==$oldpassword) {
           $status =  DB::UPDATE("update userAuthDetails SET password=? WHERE id=?",[$oldpassword,$uid]); 
           if($status === 1){
            return response()->json(['data'=>$status,'status'=>'success','message' => 'Password ResetSuccessfully'], 200);
           }else{
            return response()->json(['data'=>$status,'status'=>'failed','message' => 'DB or QUERY ERROR'], 401);
           }
        }

        return response()->json(['status'=>'failed','message' => 'Please Enter The Password Does not use Previously'], 401);
    }
     public function logout(Request $request)
    {
        $uid = $request->input('id');
        $status = DB::UPDATE("update userAuthDetails SET activeStatus=false WHERE id=?",[$uid]); 
        if ($status===1) {
            return response()->json(['changestatus'=>$status,'status'=>'success','message' => 'Successfully Logout']);
        }

        return response()->json(['status'=>'failed','message' => 'Logout Failed'], 401);
    }

}

