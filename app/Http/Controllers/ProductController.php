<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        $products = product::all();
        return view("products.products", compact('sections', 'products'));
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
        //  validate  فى حالة

        $validatedData = $request->validate([

            'product_name' => 'required',
            'section_name' => 'required',
            'description' => 'required',
            //جعل الخطأ بالعربية
        ], [
            'product_name.required' => "يرجى ادخال اسم المنتج",
            'section_name.required' => "يرجى ادخال اسم القسم",
            'description.required' => "يرجى ادحال الملاحظات",
        ]);

        product::create([
            "product_name" => $request->product_name,
            "section_id" => $request->section_name,
            "description" => $request->description

        ]);
        session()->flash("Add", "تم اضافة المنتج بنجاح");
        return redirect("/products");
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = section::where('section_name', $request->section_name)->first()->id;

        $Products = product::findOrFail($request->pro_id);

        $Products->update([
            'product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Products = product::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
