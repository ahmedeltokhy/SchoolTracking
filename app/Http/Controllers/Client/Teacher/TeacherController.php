<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use auth;
use App\Models\{ClassSection,Attendance};
class TeacherController extends Controller
{
    public function list_sections(){
        $classSections = auth('client')->user()->classsections;
        // dd($classSections);
        return view('teacher.classSections.index', compact('classSections'));
    }
    public function view_section($id){
        $classSection = ClassSection::where(["id"=>$id,"teacher_id"=>auth('client')->id()])->firstOrFail();
        return view('teacher.classSections.show', compact('classSection'));
    }
    
    
    
    
}
