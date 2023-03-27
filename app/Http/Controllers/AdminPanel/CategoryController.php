<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view ('AdminPanel.category.category');
    }
    public function add( ){
        return view('AdminPanel.category.add_category ');
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'photo' => ' image|nullable',
            'status' => 'required|in:active,inactive'
        ]);

        $category_image = $request->file('photo');
        if ($category_image){
            $imageName = $category_image->getClientOriginalName();
            $directory = 'assets/images/category/';
            $imageUrl = $directory.$imageName;
            $category_image -> move($directory,$imageName);

            $category = new Category();
            $category->title = $request->title;
            $category->summary = $request->summary;
            $category->status = $request->status;
            $category->photo = $imageUrl ;
            $category->save();
        }else{
            $category = new Category();
            $category->title = $request->title;
            $category->summary = $request->summary;
            $category->status = $request->status;
//            $category->title = $imageUrl ;
            $category->save();
        }
        Toastr::success('New Category added', 'Success', ["positionClass" => "toast-top-right"]);

        return back();
    }

    public function unpublished($id){
        $category = Category::find($id);
        $category -> status = 'inactive';
        $category->save();
        Toastr::success('Category Inactive', 'Success', ["positionClass" => "toast-top-right"]);

        return back();
    }
    public function published($id){
        $category = Category::find($id);
        $category -> status = 'active';
        $category->save();
        Toastr::success('Category Active', 'Success', ["positionClass" => "toast-top-right"]);

        return back();
    }
    public function destroy($id){
        $category = Category::find($id);
        if($category->photo){
            unlink($category->photo);
        }

        $category->delete();

         return response()->json(['success'=>'Category Delete Successfully!!']);
    }
    public function edit($id){
        $category = Category::find($id);
        return view('AdminPanel.category.edit_category',[
            'category'=>$category
        ]);
    }
    public function update(Request $request){
        $category = Category::find($request->id);
        $category_image = $request->file('photo');
        if ($category_image){
            $imageName = $category_image->getClientOriginalName();
            $directory = 'assets/images/category/';
            $imageUrl = $directory.$imageName;
            $category_image -> move($directory,$imageName);

//            $category = new Category();
            $category->title = $request->title;
            $category->summary = $request->summary;
            $category->status = $request->status;
            $category->photo = $imageUrl ;
            $category->save();
        }else{
//            $category = new Category();
            $category->title = $request->title;
            $category->summary = $request->summary;
            $category->status = $request->status;
//            $category->title = $imageUrl ;
            $category->save();
        }
        Toastr::success('Category Updated', 'Success', ["positionClass" => "toast-top-right"]);

        return redirect('admin/category');
    }
}
