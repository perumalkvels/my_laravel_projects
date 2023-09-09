<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function createUser(Request $request){
        
        DB::insert("INSERT INTO user_data (uname, password, email, mobileno, salary, branchname, brachlocation) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $request->uname,
            $request->password,
            $request->email,
            $request->mobileno,
            $request->salary, 
            $request->branchname,
            $request->brachlocation
        ]);
        
        return response()->json([
            "message" => "Successfully Created",
            "status" => "success"
        ]);
    }
    public function getUsers(){
       $detail= DB::Select("SELECT * FROM user_data");
        return response()->json([
           "data" => $detail,
            "status" => "success"
        ]);
    }
    // public function searchUser(Request $request){
    //     $detail= DB::Select("SELECT * FROM user_data");
    //      return response()->json([
    //         "data" => $detail,
    //          "status" => "success"
    //      ]);
    //  }
    public function delUsers(Request $request){
        $detail= DB::Select("DELETE FROM user_data WHERE id=?",[$request->id]);
         return response()->json([
            "message" => "Successfully Deleted",
            "status" => "success"
         ]);
     }

   
}
