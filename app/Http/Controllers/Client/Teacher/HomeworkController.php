<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use auth;
use App\Models\{ClassSection,Attendance,Homework};
class HomeworkController extends Controller
{
    public function list_homeworks(){
        $homeworks = auth('client')->user()->homeworks;
        return view('teacher.homework.index', compact('homeworks'));
    }
}
