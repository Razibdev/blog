<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Toastr;

class SubscriberController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:subscribers'
        ]);

        $subscriber = new Subscriber;
        $subscriber->email = $request->email;
        $subscriber->save();
        Toastr::success('You successfully added to our subscriber list', 'success');
        return redirect()->back();
    }
}
