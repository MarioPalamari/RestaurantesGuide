<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;

class AdminController extends Controller
{
    public function showAdminDashboard(){
        return view('admin.admin');
    }

    public function mostrarpagina()
    {
        return view('admin.users.index');
    }
    public function index()
    {
        $users = User::with('rol')->get();
        $roles = Rol::all();
    
        return response()->json(['usuarios' => $usuarios, 'roles' => $roles]);
        
    }
    

    public function create()
    {
        $roles = Rol::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol_id' => $request->rol_id
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit(User $user)
    {
        $roles = Rol::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . $user->id,
            'password' => 'nullable|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'rol_id' => $request->rol_id
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente');
    }


}
