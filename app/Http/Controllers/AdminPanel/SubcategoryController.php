<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    public function index(){
        $subcategories = Subcategory::all();
        return view('AdminPanel.subcategory.subcategory', compact('subcategories'));
    }
    public function add(){
        return view('AdminPanel.subcategory.add_subcategory');
    }

    public function save(Request $request){

        $request->validate([
            'title' => 'required',
            'photo' => ' image|nullable',
            'status' => 'required|in:active,inactive'
        ]);

        $subcategory_image = $request->file('photo');
        if ($subcategory_image){
            $imageExt = $subcategory_image->getClientOriginalExtension();
            $newImageName = $request->title.'-'.time().'.'.$imageExt;
            $directory = 'assets/images/category/';
            $imageUrl = $directory.$newImageName;
            $subcategory_image -> move($directory,$newImageName);

            $subcategory = new Subcategory();
            $subcategory->title = $request->title;
            $subcategory->category_id = $request->category_id;
            $subcategory->summary = $request->summary;
            $subcategory->status = $request->status;
            $subcategory->photo = $imageUrl;
            $subcategory->save();
        }else{
            $subcategory = new Subcategory();
            $subcategory->photo = "default.jpg";
            $subcategory->title = $request->title;
            $subcategory->category_id = $request->category_id;
            $subcategory->summary = $request->summary;
            $subcategory->status = $request->status;
            $subcategory->save();
        }
        Toastr::success('New Subcategory Added', 'Success', ["positionClass" => "toast-top-right"]);

        return redirect()->route('admin.subcategory');


    }

    public function edit($id)
    {
       $categories = Category::where('status', 'active')->get();
       // return $categories;
       $subcategory = Subcategory::find($id);
       return view('AdminPanel.subcategory.edit-subcategory', compact('subcategory','categories'));
    }

    public function update(Request $request){
        $subcategory = Subcategory::find($request->id);
        $subcat_image = $request->file('photo');
        if ($subcat_image){
            $imageExt = $subcat_image->getClientOriginalExtension();
            $newImageName = $request->title.'-'.time().'.'.$imageExt;
            $directory = 'assets/images/category/';
            $imageUrl = $directory.$newImageName;
            $subcat_image -> move($directory,$newImageName);

            if (file_exists($subcategory->photo)) {
                 unlink($subcategory->photo);
            }

            $subcategory->title = $request->title;
            $subcategory->category_id = $request->category_id;
            $subcategory->summary = $request->summary;
            $subcategory->status = $request->status;
            $subcategory->photo = $imageUrl;
            $subcategory->save();
        }else{
            $subcategory->title = $request->title;
            $subcategory->category_id = $request->category_id;
            $subcategory->summary = $request->summary;
            $subcategory->status = $request->status;
            $subcategory->save();
        }
        Toastr::success('Subcategory Updated', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.subcategory');
    }


    public function unpublished($id){
        $subcategory = Subcategory::find($id);
        $subcategory -> status = 'inactive';
        $subcategory->save();

        Toastr::success('Subcategory Inactive', 'Success', ["positionClass" => "toast-top-right"]);

        return back();
    }
    public function published($id){
        $subcategory = Subcategory::find($id);
        $subcategory -> status = 'active';
        $subcategory->save();

        Toastr::success('Subcategory Active', 'Success', ["positionClass" => "toast-top-right"]);

        return back();
    }

    public function destroy(Request $request){
        $subcategory = Subcategory::find($request->id);
        // unlink($subcategory->photo);
        $subcategory->delete();

        return response()->json(['success'=>'Subcategory Delete Successfully!!']);
    }
}
