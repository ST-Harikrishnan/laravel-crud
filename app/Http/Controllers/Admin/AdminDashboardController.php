<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function makeAdmin($id): RedirectResponse
{
    $user = User::findOrFail($id);

    // Prevent assigning admin role to already-admin users
     if ($user->role !== 'admin') {
            $user->role = 'admin';
            $user->save();
        }

    return redirect()->back()->with('success', $user->name . ' is now an admin.');
}

// public function getUsersData(Request $request)
// {
//     $users = User::query()->select(['id', 'name', 'email', 'role']);

//     if ($request->has('role') && $request->role !== '') {
//         $users->where('role', $request->role);
//     }

//     return DataTables::of($users)
//         ->addColumn('role', function ($user) {
//             if ($user->role === 'admin') {
//                 return '<span class="badge bg-success">Admin</span>';
//             }

//             return '<form action="' . route('admin.make-admin', $user->id) . '" method="POST" class="d-inline">
//                         ' . csrf_field() . '
//                         <button type="submit" class="btn btn-sm btn-warning">Make Admin</button>
//                     </form>';
//         })
//         ->addColumn('action', function ($user) {
//             return '<form action="' . route('admin.send-welcome-email', $user->id) . '" method="POST" class="d-inline">
//                         ' . csrf_field() . '
//                         <button class="btn btn-sm btn-primary">Send Email</button>
//                     </form>';
//         })
//         ->rawColumns(['role', 'action'])
//         ->make(true);
// }

public function getUsersData(Request $request)
{
    $query = User::query();

    if ($request->has('role') && $request->role != '') {
        $query->where('role', $request->role);
    }

    return DataTables::of($query)
    
        // ->addColumn('action', function ($user) {
        //     return view('admin.partials.user-actions', compact('user'))->render();
        // })

        ->addColumn('action', function ($user) {
            return '<form action="' . route('admin.send-welcome-email', $user->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <button class="btn btn-sm btn-primary">Send Email</button>
                    </form>';
        })
        ->addColumn('action', function ($user) {
    return '
        <div class="d-flex gap-2 align-items-center">

            <form action="' . route('admin.send-welcome-email', $user->id) . '" method="POST" class="d-inline">
                ' . csrf_field() . '
                <button type="submit" class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="tooltip" title="Send welcome email">
                    <i class="bi bi-envelope-fill"></i>
                </button>
            </form>

            <a href="' . route('user.edit', $user->id) . '" class="btn btn-sm btn-outline-warning shadow-sm" data-bs-toggle="tooltip" title="Edit user">
                <i class="bi bi-pencil-square"></i>
            </a>

            <form action="' . route('user.destroy', $user->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" data-bs-toggle="tooltip" title="Delete user">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </form>

        </div>
    ';
})


        ->rawColumns(['action']) // allow HTML rendering
        ->make(true);
}



public function dashboard()
{
    return view('admin.dashboardcount', [
        'userCount'     => User::count(),
        'postCount'     => Post::count(),
        'categoryCount' => Category::count(),
        'tagCount'      => Tag::count(),
        'recentPosts' => Post::latest()->take(6)->get()
    ]);
}

}
    