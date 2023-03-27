<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Color;
use Carbon\Carbon;

class ColorController extends Controller
{
    public function index()
    {
        $datas = Color::all();
        return view('AdminPanel.Color.color', compact('datas'));
    }

    public function add()
    {
        return view('AdminPanel.Color.add-color');
    }

    public function store(Request $request)
    {
       $request->validate([
            'color_name' => 'required',
            'color_code' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

       Color::insert([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'status'     => $request->status,
            'created_at' =>Carbon::now(),
       ]);

        Toastr::success('New Color added', 'Success', ["positionClass" => "toast-top-right"]);

       return redirect()->route('admin.color');
    }

    public function status($id)
    {
        $color_status = Color::find($id);

        if ($color_status->status == "active") {
            Color::where('id',$color_status->id)->update([
                 'status' =>  'inactive',
            ]);

            Toastr::success('Color Inactive', 'Success', ["positionClass" => "toast-top-right"]);

            return back();

        }else{
            Color::where('id',$color_status->id)->update([
                 'status' =>  'active',
            ]);

            Toastr::success('Color Active', 'Success', ["positionClass" => "toast-top-right"]);

            return back();
        }
    }

    public function edit($id){
       $color_edit = Color::find($id);
       return view('AdminPanel.Color.color-edit', compact('color_edit'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'color_name' => 'required',
            'color_code' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        Color::where('id', $request->id)->update([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'status'     => $request->status,
            'updated_at' =>Carbon::now(),
        ]);

        Toastr::success('Color Updated', 'Success', ["positionClass" => "toast-top-right"]);

        return redirect()->route('admin.color');
    }


    public function destroy($id)
    {
        $color_id = Color::find($id);
        $color_id->delete();
        return response()->json(['success'=>'Color Delete Successfully!!']);
    }
}
