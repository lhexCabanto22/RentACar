<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $office = Customer::whereHas('offices', function($o) use($user){
            return $o->where('office_id', $user->office_id);
        })->get();
        return response()->json(['office' => $office], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->office_id;

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'purok' => $request->purok,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'contact' => $request->contact,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $customerId = $customer->id;

        $customers = Customer::find($customerId);
        $customers->offices()->attach($user);
        
        return response()->json(['customer' => $customer], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    public function update(Request $request, $id)
    {
        
        $customer = Customer::find($id);

        $customer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'purok' => $request->purok,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'contact' => $request->contact,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['customer' => $customer], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    

   

    public function delete($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json(['customer' => $customer], 200);
    }
}
