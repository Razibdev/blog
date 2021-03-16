<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Toastr;
class AuthorController extends Controller
{
   public function index(){
     $authors = User::authors()
                    ->withCount('posts')
                    ->withCount('comments')
                    ->withCount('favorite_posts')
                    ->get();

        return view('admin.authors', compact('authors'));

   }

   public function destroy($id){
       User::findOrFail($id)->delete();
       Toastr::success('Author Successfully Deleted', 'Success');
       return redirect()->back();
   }
}
