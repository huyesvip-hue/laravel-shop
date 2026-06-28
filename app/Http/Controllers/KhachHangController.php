<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class KhachHangController extends Controller
{
   public function index(Request $request)
    {
        $query = User::with('role');

        // Tên
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Email
        if ($request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Role
        if ($request->role) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(10)->appends($request->all());

        return view('admin.khachhang', compact('users'));
    }

    public function create()
    {
        return view('admin.themkh');
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',

            'role_id' => 'required'

        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role_id' => $request->role_id

        ]);

        return redirect()
            ->route('admin.khachhang.index')
            ->with('success', 'Thêm khách hàng thành công');
    }

     // EDIT FORM
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.themkh', compact('user', 'roles'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id
        ];

        // chỉ update password nếu có nhập
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.khachhang.index')
            ->with('success', 'Cập nhật thành công');
    }

    // DELETE
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.khachhang.index')
            ->with('success', 'Xóa thành công');
    }
}