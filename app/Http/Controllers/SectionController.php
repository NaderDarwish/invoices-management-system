<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use App\Models\section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        return view("sections.sections", compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
            //جعل الخطأ بالعربية
        ], [
            'section_name.required' => "يرجى ادخال اسم القسم",
            'section_name.unique' => "القسم مسجل مسبقا",
            'description.required' => "يرجى دخال الملاحظات",
        ]);

        section::create([
            "section_name" => $request->section_name,
            "description" => $request->description,
            "created_by" => (Auth::user()->name)
        ]);
        session()->flash("Add", "تم اضافة القسم بنجاح");
        return redirect("/sections");

        // طريقة اخرى


        // $input = $request->all();
        // //التاكد من التسجيل مسبقا
        // $b_exists = section::where("section_name", "=", $input["section_name"])->exists();

        // if ($b_exists) {
        //     session()->flash("Error", "خطأ القسم مسجل مسبقا");
        //     return redirect("/sections");
        // } else {
        //     section::create([
        //         "section_name" => $request->section_name,
        //         "description" => $request->description,
        //         "created_by" => (Auth::user()->name)
        //     ]);
        //     session()->flash("Add", "تم اضافة القسم بنجاح");
        //     return redirect("/sections");
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
            'description' => 'required',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال البيان',

        ]);

        $sections = section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاج');
        return redirect('/sections');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        section::find($id)->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
