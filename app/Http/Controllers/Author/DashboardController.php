<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $posts = $user->posts;
        $propular_posts = $user->posts()
                            ->withCount('comments')
                            ->withCount('favorite_to_users')
                            ->orderBy('view_count', 'desc')
                            ->orderBy('comments_count')
                            ->orderBy('favorite_to_users_count')
                            ->take(5)
                            ->get();
        $total_pending_posts = $posts->where('is_approved', false)->count();
        $all_view = $posts->sum('view_count');
            
        return view('author.dashboard', compact('user','posts', 'propular_posts', 'total_pending_posts', 'all_view'));
    }
}
