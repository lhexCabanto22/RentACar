<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $user = Auth::user();
        $rents = Rent::whereHas('car', function($cars)use($user){
            return $cars->where('office_id', $user->office_id);
        })->with('car','customer')->get();
        return response()->json(['rent' => $rents], 200);
    }

    public function display()
    {
        $cars = Auth::user();
        $cars = Car::where('office_id', $cars->office_id)->where('status', 0)->with('brand','office')->get();
        
        return response()->json(['cars' => $cars], 200);
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
        $rent_car = Car::find($request->car_id);
        $rent_car->rents()->create([
            'quantity'=> $request->quantity,
            'rent_date'=> $request->rent_date,
            'return_date'=> $request->return_date,
            'customer_id'=> $request->customer_id,
            'car_id' => $request->car_id
        ]);
        $rentID = $rent_car->id;

        $car = Car::where('id', $request->car_id)->update(['status' => 1]);

        $notify = Notification::create([
            'rent_id' => $rentID,
            'office_id' => Auth::user()->office_id,
            'description' => $request->description
        ]);
        return response()->json(['rent'=>$rent_car, 'notify' => $notify, 'car'=> $car], 200);
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
        
        $rents = Rent::find($id);
        
        $rents->update([
            'quantity'  => $request->quantity,
            'rent_date' => $request->rent_date,
            'return_date' => $request->return_date,
            'car_id' => $request->car_id,
            'customer_id' => $request->customer_id
        ]);

        return response()->json(['rent' => $rents]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rents = Rent::find($id);

        $rents->delete();

        return response()->json(['rent' => $rents]);
    }

    public function updateStatus($id)
    {
        $rents = Rent::find($id);
        $rents->update([
            'status' => 1
        ]);

    }
}
