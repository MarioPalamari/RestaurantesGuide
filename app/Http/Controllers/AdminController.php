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
        $usuarios = User::with('rol')->get();
        $roles = Rol::all();
    
        return response()->json([
            'usuarios' => $usuarios,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|min:6',
                'rol_id' => 'required|exists:roles,id'
            ]);

            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'rol_id' => $request->rol_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }
}
