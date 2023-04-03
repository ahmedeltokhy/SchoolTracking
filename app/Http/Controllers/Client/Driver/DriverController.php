<?php

namespace App\Http\Controllers\Client\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Client,Bus,CheckStation};
use Carbon\Carbon;
class DriverController extends Controller
{
    public function index(){
        $buses=auth('client')->user()->buses_driver;
        return view("driver.list_buses",compact('buses'));
    }
    public function check_station($id){
        $bus=Bus::where(["id"=>$id,"driver_id"=>auth('client')->id()])->first();
        $stations=$bus->stations;
        $check_station=CheckStation::where(["date"=>Carbon::today(),"bus_id"=>$id])->pluck("status","bus_station_id")->toArray();
        
        return view("driver.list_stations",compact("stations","bus","check_station"));
        // dd($stations,$check_stations);

    }
    public function update_stations($bus_id,Request $request){
        $request->validate([
            'status' => 'required|array',
            'status.*' => 'required|in:1,0',
        ]);
        foreach($request->status as $key=>$value){

            $check_station=CheckStation::updateOrCreate(["date"=>Carbon::today(),"bus_station_id"=>$key,"bus_id"=>$bus_id],
            [
                "status"=>$value,
                "driver_id"=>auth("client")->id(),
            ]);
        }
        return redirect()->route("driver.buses.index");
        
    }
}
