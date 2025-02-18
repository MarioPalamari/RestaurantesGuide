<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use Illuminate\Support\Facades\DB;

class RestaurantesAdminController extends Controller
{
    public function ShowAdminRestaurantes()
    {
        $restaurantes = Restaurante::with('etiquetas')->get();
        $etiquetas = \App\Models\Etiqueta::all();
        return view('admin.admin-restaurante', compact('restaurantes', 'etiquetas'));
    }

    public function listarRestaurantes(Request $request)
    {
        $query = Restaurante::with('etiquetas');

        // Filtro por nombre
        if ($request->has('nombre') && $request->nombre != '') {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por lugar
        if ($request->has('lugar') && $request->lugar != '') {
            $query->where('lugar', 'like', '%' . $request->lugar . '%');
        }

        // Filtro por etiquetas
        if ($request->has('etiquetas') && !empty($request->etiquetas)) {
            $etiquetasNombres = explode(',', $request->etiquetas);
            $query->whereHas('etiquetas', function($q) use ($etiquetasNombres) {
                $q->whereIn('nombre', $etiquetasNombres);
            });
        }

        // Ordenación
        if ($request->has('sort_column') && $request->has('sort_order')) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $restaurantes = $query->get();
        $etiquetas = \App\Models\Etiqueta::all();

        return response()->json([
            'restaurantes' => $restaurantes,
            'etiquetas' => $etiquetas
        ]);
    }
public function crearRestaurante(Request $request)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_medio' => 'nullable|numeric',
            'img' => 'nullable|image|max:2048',
            'lugar' => 'nullable|string',
            'horario' => 'nullable|string',
            'contacto' => 'nullable|string',
            'web' => 'nullable|url',
            'etiquetas' => 'nullable|array'
        ]);

        $imagenPath = null;
        if ($request->hasFile('img')) {
            $imagen = $request->file('img');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $rutaDestino = public_path('img');
            $imagen->move($rutaDestino, $nombreArchivo);
            $imagenPath = $nombreArchivo;
        }

        $restaurante = Restaurante::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_medio' => $request->precio_medio,
            'img' => $imagenPath,
            'lugar' => $request->lugar,
            'horario' => $request->horario,
            'contacto' => $request->contacto,
            'web' => $request->web
        ]);

        // Asociar etiquetas si existen
        if ($request->has('etiquetas')) {
            $restaurante->etiquetas()->attach($request->etiquetas);
        }

        DB::commit();

        return response()->json([
            'mensaje' => 'Restaurante creado correctamente',
            'restaurante' => $restaurante
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'mensaje' => 'Error al crear el restaurante',
            'error' => $e->getMessage()
        ], 500);
    }
}
    
    public function mostrarRestaurante($id)
    {
        $restaurante = Restaurante::with('etiquetas')->findOrFail($id);
        $etiquetas = \App\Models\Etiqueta::all();
        
        // Obtener los IDs de las etiquetas asociadas al restaurante
        $etiquetasAsociadas = $restaurante->etiquetas->pluck('id')->toArray();
        
        // Crear un nuevo array de etiquetas transformadas
        $etiquetasTransformadas = $etiquetas->map(function($etiqueta) use ($etiquetasAsociadas) {
            return [
                'id' => $etiqueta->id,
                'nombre' => $etiqueta->nombre,
                'selected' => in_array($etiqueta->id, $etiquetasAsociadas)
            ];
        });
        
        // Reemplazar las etiquetas originales con las transformadas
        $restaurante->etiquetas_transformadas = $etiquetasTransformadas;
        
        return response()->json(['restaurante' => $restaurante]);
    }
    
    

    public function actualizarRestaurante(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'precio_medio' => 'nullable|numeric',
                'img' => 'nullable|image|max:2048',
                'lugar' => 'nullable|string',
                'horario' => 'nullable|string',
                'contacto' => 'nullable|string',
                'web' => 'nullable|url',
                'etiquetas' => 'nullable|array'
            ]);
    
            $restaurante = Restaurante::findOrFail($id);
    
            $imagenPath = $restaurante->img;
            if ($request->hasFile('img')) {
                $imagen = $request->file('img');
                $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
                $rutaDestino = public_path('img');
                $imagen->move($rutaDestino, $nombreArchivo);
                $imagenPath = $nombreArchivo;
            }
    
            $restaurante->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_medio' => $request->precio_medio,
                'img' => $imagenPath,
                'lugar' => $request->lugar,
                'horario' => $request->horario,
                'contacto' => $request->contacto,
                'web' => $request->web
            ]);
    
            // Sincronizar etiquetas
            if ($request->has('etiquetas')) {
                $restaurante->etiquetas()->sync($request->etiquetas);
            } else {
                $restaurante->etiquetas()->detach();
            }
    
            DB::commit();
    
            return response()->json([
                'mensaje' => 'Restaurante actualizado correctamente',
                'restaurante' => $restaurante
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'mensaje' => 'Error al actualizar el restaurante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminarRestaurante($id)
    {
        DB::beginTransaction();
        try {
            $restaurante = Restaurante::findOrFail($id);
    
            // Eliminar registros en tablas relacionadas
            $restaurante->cartas()->delete();
            $restaurante->valoraciones()->delete();
            $restaurante->redesSociales()->detach(); // Al ser belongsToMany, usamos detach()
            $restaurante->etiquetas()->detach(); // También es belongsToMany, se usa detach()
    
            // Ahora sí, eliminar el restaurante
            $restaurante->delete();
    
            DB::commit();
    
            return response()->json([
                'mensaje' => 'Restaurante eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'mensaje' => 'Error al eliminar el restaurante',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    
    
}
