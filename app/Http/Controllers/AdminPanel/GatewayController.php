<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Gateway;

class GatewayController extends Controller
{
    public function gateway_sslcommerz(Request $request)
    {

    	if ($request->file('image')) {
    		$file = $request->file('image');
    		$file_ext = $file->getClientOriginalExtension();
    		$file_name = time()."-".$file_ext;
    		$url = 'Admin/image/gateway-image/';
    		$directory = $url.$file_name;
    		$file->move($url,$file_name);
    		Gateway::where('code', $request->code)->update([
    		   "client_id"  => $request->client_id,
    		   "screet_key"  => $request->screet_key,
    		   "images"     => $directory,
    		   "updated_at" => Carbon::now(),
    	    ]);

    	}else{
    		Gateway::where('code', $request->code)->update([
    		   "client_id"  => $request->client_id,
    		   "screet_key"  => $request->screet_key,
    		   "updated_at" => Carbon::now(),
    	    ]);
    	}
        Toastr::success('SSLcommerz update Successfully!!', 'Success', ["positionClass" => "toast-top-right"]);

    	return back();


    }

    public function gateway_paypal(Request $request)
    {

    	if ($request->file('image')) {
    		$file = $request->file('image');
    		$file_ext = $file->getClientOriginalExtension();
    		$file_name = time()."-".$file_ext;
    		$url = 'Admin/image/gateway-image/';
    		$directory = $url.$file_name;
    		$file->move($url,$file_name);

    		Gateway::where('code', $request->code)->update([
    		   "client_id"  => $request->client_id,
    		   "screet_key"  => $request->screet_key,
    		   "images"     => $directory,
    		   "updated_at" => Carbon::now(),
    	    ]);

    	}else{
    		Gateway::where('code', $request->code)->update([
    		   "client_id"  => $request->client_id,
    		   "screet_key"  => $request->screet_key,
    		   "updated_at" => Carbon::now(),
    	    ]);
    	}
        Toastr::success('Paypal update Successfully!!', 'Success', ["positionClass" => "toast-top-right"]);

    	return back();


    }

    public function gateway_stripe(Request $request)
    {

    	if ($request->file('image')) {
    		$file = $request->file('image');
    		$file_ext = $file->getClientOriginalExtension();
    		$file_name = time()."-".$file_ext;
    		$url = 'Admin/image/gateway-image/';
    		$directory = $url.$file_name;
    		$file->move($url,$file_name);
    		Gateway::where('code', $request->code)->update([
    		   "client_id"  => $request->client_id,
    		   "screet_key"  => $request->screet_key,
    		   "images"     => $directory,
    		   "updated_at" => Carbon::now(),
    	    ]);

    	}else{
    		Gateway::where('code', $request->code)->update([
    		   "client_id"  => $request->client_id,
    		   "screet_key"  => $request->screet_key,
    		   "updated_at" => Carbon::now(),
    	    ]);
    	}
        Toastr::success('Stripe update Successfully!!', 'Success', ["positionClass" => "toast-top-right"]);

    	return back();


    }
}
