<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\User;


class UserController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if (User::where('username', $request['username'])->first()) {
            return response()->json(['status' => 'fail', 'message' => 'Username already exists']);
        }

        $user = new User;
        $user->username = $request['username'];
        $user->password = Hash::make($request['password']);
        $user->api_key = '';
        if($user->save()) {
            return response()->json(['status' => 'success', 'result' => $user]);
        } else {
            return response()->json(['status' => 'fail']);
        }
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->input('username'))->first();
        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(40));
            User::where('username', $request->input('username'))->update(['api_key' => "$apikey"]);;
            return response()->json(['status' => 'success', 'api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }
} 