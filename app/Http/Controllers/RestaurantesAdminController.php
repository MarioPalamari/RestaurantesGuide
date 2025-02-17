<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Restaurante;


class RestaurantesAdminController extends Controller
{
    public function ShowAdminRestaurantes()
    {
        return view('admin.admin-restaurante'); // Asegúrate de tener esta vista
    }

    public function listarRestaurantes()
    {
        $restaurantes = Restaurante::all();
        return response()->json($restaurantes);
    }
    public function crearRestaurante(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_medio' => 'nullable|numeric',
            'img' => 'nullable|image|max:2048'
        ]);
    
        // Manejo de la imagen si existe
        $imagenPath = null;
        if ($request->hasFile('img')) {
            $imagen = $request->file('img');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName(); // Nombre único
            $rutaDestino = public_path('img'); // Ruta en public/img/restaurantes
    
            // Mover el archivo a la carpeta public/img/
            $imagen->move($rutaDestino, $nombreArchivo);
    
            // Guardar la ruta relativa en la base de datos
            $imagenPath = 'img/' . $nombreArchivo;
        }
    
        // Crear el restaurante
        $restaurante = Restaurante::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_medio' => $request->precio_medio,
            'img' => $imagenPath
        ]);
    
        // Respuesta en formato JSON
        return response()->json([
            'mensaje' => 'Restaurante creado correctamente',
            'restaurante' => $restaurante
        ]);
    }
    
    
    

    public function actualizarRestaurante(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_medio' => 'nullable|numeric',
            'img' => 'nullable|image|max:2048'
        ]);

        $restaurante = Restaurante::findOrFail($id);
        $imagenPath = $restaurante->img;

        if ($request->hasFile('img')) {
            $imagenPath = $request->file('img')->store('restaurantes', 'public');
        }

        $restaurante->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_medio' => $request->precio_medio,
            'img' => $imagenPath
        ]);

    }

    public function eliminarRestaurante($id)
    {

        // Eliminar el restaurante
        $eliminar = Restaurante::find($id);
        $eliminar -> delete();
    }
}
