<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ClassSection,Attendance};
class StudentController extends Controller
{
    public function list_sections(){
        $classSections = ClassSection::whereHas("students",function($q){
            $q->where("id",auth('client')->id());
        })->get();
        return view('student.classSections.index', compact('classSections'));
    }
    public function view_section($id){
        $classSection = ClassSection::where(["id"=>$id])->whereHas("students",function($q){
            $q->where("id",auth('client')->id());
        })->firstOrFail();
        return view('student.classSections.show', compact('classSection'));
    }
    public function homeworks($id){
        $classsection = ClassSection::where(["id"=>$id])->whereHas("students",function($q){
            $q->where("id",auth('client')->id());
        })->firstOrFail();
        if(empty($classSection)){
            abort(403, 'Access denied');
        }
        $homeworks=$classsection->homeworks;
    }
}
