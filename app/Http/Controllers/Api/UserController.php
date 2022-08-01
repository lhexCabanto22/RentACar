<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        $user = User::where('office_id', $user->office_id)->with('office', 'role')->get();

        return response()->json(['users' => $user], 200);

        // return response()->json(['users' => User::all()], 200);
    }

    public function store(Request $request)
    {   

        $user = User::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'office_id' => $request->office_id,
            'role_id' => $request->role_id
        ]);
        return response()->json(['user' => $user], 200);
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'passowrd' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);
        return response()->json(['user' => $user], 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['user'=>$user], 200);
    }

}
