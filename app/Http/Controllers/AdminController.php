<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showAdminDashboard(){
        return view('admin.admin');
    }

    public function mostrarpagina()
    {
        $roles = Rol::all();
        return view('admin.users.index', compact('roles'));
    }

    public function index(Request $request)
    {
        $query = User::with('rol');

        if ($request->has('nombre') && $request->nombre != '') {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->has('email') && $request->email != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->has('rol_id') && $request->rol_id != '') {
            $query->where('rol_id', $request->rol_id);
        }

        if ($request->has('sort_column') && $request->has('sort_order')) {
            $column = $request->sort_column;
            $order = $request->sort_order;

            if ($column === 'rol') {
                $query->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                      ->orderBy('roles.nombre', $order);
            } else {
                $query->orderBy($column, $order);
            }
        }

        $usuarios = $query->get();
        $roles = Rol::all();
    
        return response()->json([
            'usuarios' => $usuarios,
            'roles' => $roles
        ]);
    }
public function store(Request $request)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol_id' => $request->rol_id
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Hubo un error al crear el usuario'
        ], 500);
    }
}

public function update(Request $request, User $user)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $user->id,
            'password' => 'nullable|string|min:6',
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

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Hubo un error al actualizar el usuario'
        ], 500);
    }
}

public function destroy(User $user)
{
    DB::beginTransaction();
    try {
        $user->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Hubo un error al eliminar el usuario'
        ], 500);
    }
    }
}