<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ClassSection,Message};
use Validator;
class MessageController extends Controller
{
    public function index(){
        $messages=Message::where("teacher_id",auth('client')->id())->get();
        return view("teacher.messages.index",compact('messages'));
    }
    public function show($id){
        $message=Message::where("id",$id)->where("teacher_id",auth('client')->id())->firstOrFail();
        return view("teacher.messages.show",compact('message'));
    }
    public function create(){
        $classsections = ClassSection::where("teacher_id",auth("client")->id())->pluck('subject', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $students = Client::where("type","student")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $message=Message::where("id",$id)->where("teacher_id",auth('client')->id())->get();
        return view("teacher.messages.create",compact('classsections'));
    }
    public function store(Request $request){
        $request->validate([
            'classsection_id' => 'required|exists:class_sections,id',
            'content' => 'required',
            'student_id.*' => 'integer|exists:clients,id',
            'student_id' => 'required|array',
        ]);
        foreach($request->student_id as $student_id){
            Message::create(["teacher_id"=>auth('client')->id(),'content'=>$request->content,"classsection_id"=>$request->classsection_id,'student_id'=>$student_id]);
        }
        return redirect()->route('teacher.messages.index');
    }
    public function get_students_in_classsection($id){
        $classSection = ClassSection::where(["id"=>$id,"teacher_id"=>auth('client')->id()])->firstOrFail();
        $students=$classSection->students;

    }
    
}
