<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Office;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function rentToday()
    {

        $date = Carbon::now();
        $user = Auth::user();

        $rents = Rent::whereHas('car', function($cars)use($user){
            return $cars->where('office_id', $user->office_id);
        })->with('car')->whereDate('rent_date', $date)->get();
        return response()->json(['rent' => $rents], 200);
        
    }

    public function returnToday()
    {
        $date = Carbon::now();
        $user = Auth::user();

        $rents = Rent::whereHas('car', function($cars)use($user){
            return $cars->where('office_id', $user->office_id);
        })->with('car')->whereDate('return_date', $date)->get();
        return response()->json(['rent' => $rents], 200);
    }

}
