<?php

namespace App\Http\Controllers\AdminPanel;

use App\Models\User;
use App\Services\FCMService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerNotification;

class CustomerNotificationController extends Controller
{
    public function index()
    {
        return view('AdminPanel.Notification.sendNotificationToCustomer');
    }

    public function store(Request $request){

        $request->validate([
            "title" => "required",
            "body" => "required",
        ]);


        $notification = CustomerNotification::create([
            "title" => $request->title,
            "body" =>  $request->body,
        ]);

        $users = User::all();

        //$fcm_token = "c8HlPLSZSNSGSxogNeavog:APA91bHReNMCni23G00CdJi7g6G1c6QnjkhJt1OPzLUsnrbppvWDKpFQryp1m4m2cCBQKlZAeCvPZOKlc-XhvHI5pt5gWCjVe5lLT_qDgNeKTvadiEA9OQyAFbVyFaa6uM2QeTs9MJmX";

        foreach ($users as $user){
            FCMService::send(
                $user->device_token,
                [
                    'title' => $notification->title,
                    'body' => $notification->body,
                ]
            );
        }



        Toastr::success('Notification Send Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}

