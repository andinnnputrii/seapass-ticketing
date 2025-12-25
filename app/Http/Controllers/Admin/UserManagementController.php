<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Halaman utama
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'internal'); // internal or customers

        // Statistics
        try {
        $totalAdmins = Admin::where('role', 'admin')->count();
        $totalOperators = Admin::where('role', 'operator')->count();
        } catch (\Exception $e) {
            // Fallback jika kolom role belum ada
            $totalAdmins = Admin::count();
            $totalOperators = 0;
        }

        $totalCustomers = User::count();

        try {
            $activeToday = Admin::whereDate('last_login', today())->count();
        } catch (\Exception $e) {
            // Fallback jika kolom last_login belum ada
            $activeToday = 0;
        }
        if ($tab === 'internal') {
            $users = Admin::query()
                ->when($request->search, function($q, $search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
                })
                ->when($request->role, function($q, $role) {
                    $q->where('role', $role);
                })
                ->when($request->status, function($q, $status) {
                    $q->where('status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $users = User::query()
                ->when($request->search, function($q, $search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                })
                ->when($request->status, function($q, $status) {
                    $q->where('status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('admin.users.index', compact(
            'users',
            'tab',
            'totalAdmins',
            'totalOperators',
            'totalCustomers',
            'activeToday'
        ));
    }

    // Detail user
    public function show($type, $id)
    {
        if ($type === 'internal') {
            $user = Admin::findOrFail($id);
        } else {
            $user = User::findOrFail($id);
        }

        return response()->json($user);
    }

    // Store new internal user
    public function storeInternal(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'username' => 'required|string|unique:admins,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,operator',
        ]);

        $admin = Admin::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
        ]);

        // Log activity
        ActivityLog::create([
            'user_type' => 'admin',
            'user_id' => session('admin_id'),
            'action' => 'create',
            'module' => 'users',
            'description' => "Created new {$request->role}: {$admin->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    // Update internal user
    public function updateInternal(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,'.$id,
            'role' => 'required|in:admin,operator',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        ActivityLog::create([
            'user_type' => 'admin',
            'user_id' => session('admin_id'),
            'action' => 'update',
            'module' => 'users',
            'description' => "Updated user: {$admin->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'User berhasil diupdate');
    }

    // Reset password
    public function resetPassword(Request $request, $type, $id)
    {
        $request->validate([
            'new_password' => 'required|min:6',
        ]);

        if ($type === 'internal') {
            $user = Admin::findOrFail($id);
        } else {
            $user = User::findOrFail($id);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        ActivityLog::create([
            'user_type' => 'admin',
            'user_id' => session('admin_id'),
            'action' => 'reset_password',
            'module' => 'users',
            'description' => "Reset password for: {$user->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Password berhasil direset');
    }

    // Toggle status (activate/deactivate)
    public function toggleStatus($type, $id)
    {
        if ($type === 'internal') {
            $user = Admin::findOrFail($id);
            $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        } else {
            $user = User::findOrFail($id);
            $user->update(['status' => $user->status === 'verified' ? 'suspended' : 'verified']);
        }

        return redirect()->back()->with('success', 'Status user berhasil diubah');
    }

    // Delete user
    public function destroy(Request $request, $type, $id)
{
    if ($type === 'internal') {
        $user = Admin::findOrFail($id);
    } else {
        $user = User::findOrFail($id);
    }

    $name = $user->name;
    $user->delete();

    ActivityLog::create([
        'user_type'   => 'admin',
        'user_id'     => session('admin_id'),
        'action'      => 'delete',
        'module'      => 'users',
        'description' => "Deleted user: {$name}",
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
    ]);

    return redirect()->back()->with('success', 'User berhasil dihapus');
}

}
