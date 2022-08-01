<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Office;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return  [
            'rent' => Rent::count(),
            'car' => Car::count(),
            'customer' => Customer::count(),
            'brand' => Brand::count()
        ];
    }

    public function dashboardTop()
    {
        $user = Auth::user();
        
        $rent = Rent::select('car_id', DB::raw('sum(quantity) as rented'))
        ->orderBy('rented','DESC')
        ->take(5)
        ->groupBy('car_id')
        ->whereHas('car', function($p)use($user){
            return $p->where('office_id', $user->office_id);
        })->get();

        return response()->json($rent, 200);
    }
}
