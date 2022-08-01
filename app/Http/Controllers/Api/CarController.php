<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $cars = Auth::user();
        $cars = Car::where('office_id', $cars->office_id)->with('brand','office')->get();
        
        return response()->json(['car' => $cars], 200);
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
        //
        $cars = Car::create([
            'name' => $request->name,
            'description' => $request->description,
            'plate_number' => $request->plate_number,
            'brand_id' => $request->brand_id,
            'office_id' => Auth::user()->office_id
        ]);

        return response()->json(['car' => $cars], 200);
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
        //
        $cars = Car::find($id);
        $cars->update([
            'name' => $request->name,
            'description' => $request->description,
            'plate_number' => $request->plate_number,
            'brand_id' => $request->brand_id,
            'office_id' => $request->office_id
          
        ]);
        return response()->json(['car' => $cars], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();

        return response()->json(['car'=>$car], 200);
    }

    public function updateCarStatus($id)
    {

        $car = Car::where('id', $id)->update(['status' => 0]);

        return $car;
    }
   

}
