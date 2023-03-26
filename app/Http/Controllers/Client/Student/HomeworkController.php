<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ClassSection,Attendance,Homework};

class HomeworkController extends Controller
{
    public function classsection_homeworks($classsection_id){
        $classsection = ClassSection::where(["id"=>$classsection_id])
        ->whereHas("students",function($q){
            $q->where("client_id",auth('client')->id());
        })
        ->firstOrFail();
        if(empty($classsection)){
            abort(403, 'Access denied');
        }
        $homeworks=$classsection->homeworks;
        return view('student.homeworks.index', compact('homeworks'));
    }
    public function index(){
        $homeworks=Homework::whereHas("class_section",function($qu){
            $qu->whereHas("students",function($q){
                $q->where("client_id",auth('client')->id());
            });
        })->orderByDesc("created_at")->get();
        return view('student.homeworks.index', compact('homeworks'));
    }
    public function view($id){
        $homework=Homework::where(["id"=>$id])->whereHas("class_section",function($qu){
            $qu->whereHas("students",function($q){
                $q->where("client_id",auth('client')->id());
            });
        })
        ->firstOrFail();
        if(empty($homework)){
            abort(403, 'Access denied');
        }
        $my_solutions=$homework->solutions()->where("student_id",auth('client')->id())->get();
        // dd("ss");
        return view('student.homeworks.view', compact('homework','my_solutions'));
    }
}
