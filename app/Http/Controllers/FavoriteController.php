<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Toastr;
class FavoriteController extends Controller
{
    public function add($post){
        $user = Auth::user();

        $isFavorite = $user->favorite_posts()->where('post_id', $post)->count();

        if($isFavorite == 0){
            $user->favorite_posts()->attach($post);
            Toastr::success('Post Successfully add to your favorite list', 'Success');
            return redirect()->back();

        }else{
            $user->favorite_posts()->detach($post);
            Toastr::success('Post Successfully remove to your favorite list', 'Success');
            return redirect()->back();

        }
    }
}
