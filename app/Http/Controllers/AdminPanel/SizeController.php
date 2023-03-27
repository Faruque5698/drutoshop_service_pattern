<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Size;
use Str;
use Carbon\Carbon;

class SizeController extends Controller
{
    public function index(){
        $datas = Size::all();
        return view('AdminPanel.Size.size', compact('datas'));
    }

    public function add(){
        return view('AdminPanel.Size.add-size');
    }

    public function store(Request $request){
        $this->validate($request, [
            'size_name' => 'required',
            'status' => 'required|in:active,inactive'
        ]);
        $size_name = Str::upper($request->size_name);
        Size::insert([
            'size_name' => $size_name,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        Toastr::success('New Size Added', ["positionClass" => "toast-top-right"]);

        return redirect()->route('admin.size');
    }

    public function edit($id)
    {
       $size_edit = Size::find($id);
       return view('AdminPanel.Size.size-edit', compact('size_edit'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'size_name' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $size_name = Str::upper($request->size_name);
        Size::where('id', $request->id)->update([
            'size_name' => $size_name,
            'status'     => $request->status,
            'updated_at' =>Carbon::now(),
        ]);
        Toastr::success('Size Updated', ["positionClass" => "toast-top-right"]);

        return redirect()->route('admin.size');
    }

    public function status($id)
    {
        $size_status = Size::find($id);

        if ($size_status->status == "active") {
            Size::where('id',$size_status->id)->update([
                 'status' =>  'inactive',
            ]);

            Toastr::success('Size Inactive Successfully', ["positionClass" => "toast-top-right"]);

            return back();

        }else{
            Size::where('id',$size_status->id)->update([
                 'status' =>  'active',
            ]);

            Toastr::success('Size Active Successfully', ["positionClass" => "toast-top-right"]);

            return back();
        }
    }

    public function destroy($id)
    {
        $size_id = Size::find($id);
        $size_id->delete();
        return response()->json(['success'=>'Product Delete Successfully!!']);
    }
}
