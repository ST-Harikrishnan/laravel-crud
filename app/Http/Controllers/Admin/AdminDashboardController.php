<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function makeAdmin($id): RedirectResponse
{
    $user = User::findOrFail($id);

    // Prevent assigning admin role to already-admin users
    if (!$user->is_admin) {
        $user->is_admin = true;
        $user->save();
    }

    return redirect()->back()->with('success', $user->name . ' is now an admin.');
}

public function getUsersData(Request $request)
{
    $users = User::query();

    // If filter is applied
    if ($request->has('role') && $request->role !== '') {
        if ($request->role === 'admin') {
            $users->where('is_admin', true);
        } elseif ($request->role === 'user') {
            $users->where('is_admin', false);
        }
    }

    return DataTables::of($users)
        ->addColumn('role', function ($user) {
            if ($user->is_admin) {
                return '<span class="badge bg-success">Admin</span>';
            }
            return '<form action="' . route('admin.make-admin', $user->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-sm btn-warning">Make Admin</button>
                    </form>';
        })
        ->addColumn('action', function ($user) {
            return '<form action="' . route('admin.send-welcome-email', $user->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <button class="btn btn-sm btn-primary">Send Email</button>
                    </form>';
        })
        ->rawColumns(['role', 'action'])
        ->make(true);
}

}
    