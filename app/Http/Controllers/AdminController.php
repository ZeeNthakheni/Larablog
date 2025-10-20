<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $recentPosts = Post::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        
        // Dashboard statistics
        $stats = [
            'users' => $totalUsers,
            'posts' => $totalPosts,
            'active_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'published_posts' => Post::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // Monthly data for charts
        $monthlyUsers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();

        $monthlyPosts = Post::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentUsers', 'monthlyUsers', 'monthlyPosts'));
    }

    /**
     * Show all users
     */
    public function users()
    {
        $users = User::withCount('posts')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function userShow(User $user)
    {
        $user->load('posts');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show posts management
     */
    public function posts()
    {
        $posts = Post::with('user')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Delete a user
     */
    public function userDestroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->posts()->delete();
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}