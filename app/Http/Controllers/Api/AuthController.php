<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request)
    {

        $user = User::where('email',$request->email)->with('role')->first();
        if(!$user)
        {
            return response()->json(['error' => 'Wrong Credentials'], 404);
        }
        if(Hash::check($request->password, $user->password)){
            $token = $user->createToken('accessToken')->accessToken;
            if($user->isAdmin())
            {
            
                $data['admin'] = $user->isAdmin();

            } else{ 

               
                $data['attendant'] = $user->isAttendant();
            }   
            $data['created_at'] = $user->created_at;
            $data['accessToken'] = $token;
            return response()->json($data, 200);
        }else {
            return response()->json(['status'=> 'Unauthorized Access'], 404);
        };    
      
    }

}
 
// if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
//     $user = Auth::user(); email + ' ' + text.password
//     // $data['isAdmin'] = $user->isAdmin();
//     return response()->json($data, 200,);
// } 
// else{ 
//     return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
// } 