<?php

namespace App\Http\Controllers\Client\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Client,Bus,CheckStation};
use Carbon\Carbon;
class BusController extends Controller
{
    public function index(){
        $childs_id=auth('client')->user()->childs()->pluck("id")->toArray();
        $buses=Bus::whereHas("students",function($q)use($childs_id){
            $q->whereIn("id",$childs_id);
        })->get();
        return view("parent.bus.list_buses",compact("buses"));
    }
    public function show($id){
        $childs_id=auth('client')->user()->childs()->pluck("id")->toArray();

        $bus=Bus::where(["id"=>$id])->whereHas("students",function($q)use($childs_id){
            $q->whereIn("id",$childs_id);
        })->first();
        $stations=$bus->stations;
        $check_station=CheckStation::where(["date"=>Carbon::today(),"bus_id"=>$id])->pluck("status","bus_station_id")->toArray();
        // dd( $bus);
        return view("parent.bus.list_stations",compact("stations","bus","check_station"));
    }
}
