<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(["message"=>"Bilgilerinizi kontrol ediniz.","status"=>400]);
        }
        else if ($validator->validated()) {
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
                $token =  Str::random(60);
                 $request->user()->forceFill([
                     'api_token' =>  $token,
                 ])->save();
                 return response()->json(['message'=>'Giriş başarılı','token' => $token], "200");
             }
             else{
                 return response()->json(['error'=>'Hatalı giriş'], 401);
             }
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(["message"=>"Bilgilerinizi kontrol ediniz.","status"=>400]);
        }
        else if ($validator->validated()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json(["message"=>"Kayıt Başarılı","status"=>200]);
        }
    }
    public function tokenCheck(Request $request){
        $token = $request->api_token;
        $user = User::where('api_token',$token)->first();
        if($user==null){
            return "false";
        }
        else{
            return "true";
        }
    }
}
