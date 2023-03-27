<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\EmailSetting;

class MailSettingController extends Controller
{
    public function update(Request $request)
    {

        $data = $request->validate([
            'mail_transport'  =>'required',
            'mail_host'       =>'required',
            'mail_port'       =>'required',
            'mail_username'   =>'required',
            'mail_password'   =>'required',
            'mail_encryption' =>'required',
            'mail_from'       =>'required',
        ]);

        EmailSetting::where('id',$request->id)->update($data);
        Toastr::success('Mail Settings Updated Successfully!!', 'Success', ["positionClass" => "toast-top-right"]);

        return back();
    }
}
