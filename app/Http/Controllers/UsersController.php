<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }
    /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */

    public function register(Request $request)
    {
        $full_name = $_GET['full_name'];
        $email = $_GET['email'];
        $password = $_GET['password'];

        $users = Users::where('email', $email)->first();
        
        if($users == null)
        {
            $user = Users::create([
                'full_name' => $request->query('full_name'),
                'email' => $request->query('email'),
                'password' => app('hash')->make($request->query('password')),
            ]);

            return response()->json($user, 201);
        } else{
            return response()->json('Email already exist.', 400);
        }
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
            ]);
        $user = Users::where('email', $request->input('email'))->first();
        
        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(str_random(40));
            Users::where('email', $request->input('email'))->update(['remember_token' => "$apikey"]);;
            return response()->json(['status' => 'success','remember_token' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    public function getUser($id)
    {
        $user = Users::where('id', $id)->first();

        return response()->json($user, 201);
    }
}    
?>