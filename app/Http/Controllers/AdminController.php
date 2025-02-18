<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\GerenteRestaurante;
use App\Models\Restaurante;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showAdminDashboard()
    {
        return view('admin.admin');
    }

    public function mostrarpagina()
    {
        $roles = Rol::all();
        $restaurantes = Restaurante::all();
        return view('admin.users.index', compact('roles', 'restaurantes'));
    }

    public function index(Request $request)
    {
        try {
            $query = User::with(['rol', 'gerenteRestaurante.restaurante']);

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
                'success' => true,
                'usuarios' => $usuarios,
                'roles' => $roles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:6',
                'rol_id' => 'required|exists:roles,id',
                'restaurante_id' => 'nullable|exists:restaurantes,id'
            ]);

            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'rol_id' => $request->rol_id
            ]);

            if ($request->restaurante_id) {
                GerenteRestaurante::create([
                    'id_usuario' => $user->id,
                    'id_restaurante' => $request->restaurante_id
                ]);
            }

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
                'message' => 'Hubo un error al crear el usuario: ' . $e->getMessage()
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
                'rol_id' => 'required|exists:roles,id',
                'restaurante_id' => 'nullable|exists:restaurantes,id'
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

            // Actualizar o crear la relación con el restaurante
            if ($request->restaurante_id) {
                GerenteRestaurante::updateOrCreate(
                    ['id_usuario' => $user->id],
                    ['id_restaurante' => $request->restaurante_id]
                );
            } else {
                // Si no se selecciona restaurante, eliminar la relación si existe
                GerenteRestaurante::where('id_usuario', $user->id)->delete();
            }

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
                'message' => 'Hubo un error al actualizar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->valoraciones()->delete();     
            $user->gerenteRestaurante()->delete();
            $user->delete();
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Usuario y sus relaciones eliminados exitosamente'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al eliminar el usuario y sus relaciones: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
