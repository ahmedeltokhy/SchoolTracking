<?php

namespace App\Http\Controllers\Client\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
class MessageController extends Controller
{
    public function index(){
        $childs_id=auth('client')->user()->childs()->pluck("id")->toArray();
        $messages=Message::whereIn("student_id",$childs_id)->get();
        return view("parent.messages.index",compact('messages'));
    }
    public function show($id){
        $childs_id=auth('client')->user()->childs()->pluck("id")->toArray();
        $message=Message::where("id",$id)->whereIn("student_id",$childs_id)->first();
        return view("parent.messages.show",compact('message'));    
    }
}
