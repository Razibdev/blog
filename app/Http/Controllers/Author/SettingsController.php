<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use App\User;
use Carbon\Carbon;
use Toastr;
use Auth;
use Hash;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class SettingsController extends Controller
{
    public function index(){
        return view('author.settings');
    }

    public function updateProfile(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|image'
        ]);

        $image = $request->file('image');

        $slug = Str::slug($request->name);
        $user = User::findOrFail(Auth::id());
        
        if(isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('profile')){
                Storage::disk('public')->makeDirectory('profile');
            }

            if(!Storage::disk('public')->exists('profile/'.$user->image)){
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            $profile = Image::make($image)->resize(500, 500)->stream();
            Storage::disk('public')->put('profile/'.$imageName, $profile);

        }else{
            $imageName = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();

        Toastr::success('Profile Successfully Updated', 'success');
        return redirect()->back();

    }



    public function updatePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->old_password, $hashedPassword)){
            if(!Hash::check($request->password, $hashedPassword)){
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();

                Toastr::success('Password changed Successfully', 'success');
                Auth::logout();
                return redirect()->back();
            }else{
                Toastr::error('New password cannot be the same as old passwrod', 'Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Current Password not match', 'Error');
                return redirect()->back();
        }
    }



}
