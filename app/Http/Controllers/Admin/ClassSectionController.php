<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyClassSectionRequest;
use App\Http\Requests\StoreClassSectionRequest;
use App\Http\Requests\UpdateClassSectionRequest;
use App\Models\ClassSection;
use App\Models\Client;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassSectionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('class_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classSections = ClassSection::with(['teacher', 'students'])->get();

        return view('admin.classSections.index', compact('classSections'));
    }

    public function create()
    {
        abort_if(Gate::denies('class_section_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Client::where("type","student")->pluck('name', 'id');

        return view('admin.classSections.create', compact('students', 'teachers'));
    }

    public function store(StoreClassSectionRequest $request)
    {
        $classSection = ClassSection::create($request->all());
        $classSection->students()->sync($request->input('students', []));

        return redirect()->route('admin.class-sections.index');
    }

    public function edit(ClassSection $classSection)
    {
        abort_if(Gate::denies('class_section_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Client::where("type","teacher")->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Client::where("type","student")->pluck('name', 'id');

        $classSection->load('teacher', 'students');

        return view('admin.classSections.edit', compact('classSection', 'students', 'teachers'));
    }

    public function update(UpdateClassSectionRequest $request, ClassSection $classSection)
    {
        $classSection->update($request->all());
        $classSection->students()->sync($request->input('students', []));

        return redirect()->route('admin.class-sections.index');
    }

    public function show(ClassSection $classSection)
    {
        abort_if(Gate::denies('class_section_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classSection->load('teacher', 'students');

        return view('admin.classSections.show', compact('classSection'));
    }

    public function destroy(ClassSection $classSection)
    {
        abort_if(Gate::denies('class_section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classSection->delete();

        return back();
    }

    public function massDestroy(MassDestroyClassSectionRequest $request)
    {
        $classSections = ClassSection::find(request('ids'));

        foreach ($classSections as $classSection) {
            $classSection->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
