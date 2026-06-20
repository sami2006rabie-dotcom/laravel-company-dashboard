<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $stats = [
                'total_users' => User::where('role', 'user')->count(),
                'total_departments' => Department::count(),
                'total_posts' => BlogPost::count(),
                'total_comments' => BlogComment::count(),
            ];
            $users = User::with('department')->where('role', 'user')->paginate(10);
            $departments = Department::with('users')->get();
            return view('dashboard.admin.index', compact('stats', 'users', 'departments'));
        }

        $user = Auth::user();
        $posts = $user->blogPosts()->paginate(10);
        $departmentUsers = User::where('department_id', $user->department_id)->get();
        return view('dashboard.user.index', compact('user', 'posts', 'departmentUsers'));
    }
}