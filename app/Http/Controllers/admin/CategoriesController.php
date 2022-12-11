<?php

namespace App\Http\Controllers\admin;

use Throwable;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index(){
        $categories= Category::all();
        return view('admin/categories/categories',compact('categories'));
    }  
    public function store(CategoryRequest $req){ 

        Category::create($req->all());
        return redirect()->route('categories');

    }
    public function edit($id)
    {
        $categories=Category::findOrFail($id);
        return view('admin/categories/update',compact('categories'));
    }
    public function update($id, CategoryRequest $req){

        $validator=Validator::make($req->name,[
            'name'=>'required',            
        ]);
        if($validator->fails()){
           
            return redirect()->back()->withErrors($validator);
        }
        $categories = Category::find($id);
        
        try {
            $categories->name = $req->name;
            $categories->save();
            return redirect()->back()->with('success','updated successfully');
        } catch (Throwable $e) {
            report($e);
            return false;
        }
}
}
