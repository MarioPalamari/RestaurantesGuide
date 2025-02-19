<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Valoracion;
use App\Models\restaurante_red_social;
use Illuminate\Support\Facades\DB;

class RestauranteController extends Controller
{
    public function mostrarpagina()
    {
        return view('restaurantes.restaurantes');
    }


    public function mostrarrestaurantes(Request $request)
    {
        $query = Restaurante::select([
            'restaurantes.id',
            'restaurantes.nombre',
            'restaurantes.descripcion',
            'restaurantes.precio_medio',
            'restaurantes.img',
            DB::raw('COALESCE(ROUND(AVG(valoraciones.valoracion), 2), 0) AS media_valoracion'),
            DB::raw('GROUP_CONCAT(DISTINCT etiquetas.nombre SEPARATOR ", ") AS etiquetas')
        ])
            ->leftJoin('valoraciones', 'restaurantes.id', '=', 'valoraciones.id_restaurante')
            ->leftJoin('restaurante_etiqueta', 'restaurantes.id', '=', 'restaurante_etiqueta.id_restaurante')
            ->leftJoin('etiquetas', 'restaurante_etiqueta.id_etiqueta', '=', 'etiquetas.id')
            ->groupBy('restaurantes.id');

        // FILTRO POR PRECIO
        if ($request->precio) {
            $precio = $request->precio;
            $query->where('restaurantes.precio_medio', '>=', "$precio");
        }

        // FILTRO POR TIPO DE COCINA (ETIQUETAS)
        if ($request->tipo_cocina) {
            $query->whereExists(function ($subquery) use ($request) {
                $subquery->select(DB::raw(1))
                    ->from('restaurante_etiqueta')
                    ->join('etiquetas', 'restaurante_etiqueta.id_etiqueta', '=', 'etiquetas.id')
                    ->whereRaw('restaurantes.id = restaurante_etiqueta.id_restaurante')
                    ->where('etiquetas.nombre', 'LIKE', '%' . $request->tipo_cocina . '%');
            });
        }

        // FILTRO POR VALORACIÓN

        if ($request->valoracion) {
            // having es para condición de búsqueda para un grupo o agregado.
            $query->having('media_valoracion', '>=', $request->valoracion);
        }

        // ORDENAR POR MEJOR VALORADOS
        $restaurantes = $query->orderByDesc('media_valoracion')
            ->paginate(5);

        // print_r($restaurantes);
        return response()->json(['restaurantes' => $restaurantes]);
        // return view('restaurantes.restaurantes', compact('restaurantes'));
    }

    public function mostrarpaginarestaurante(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('id')) {
            return redirect()->route('login'); // Redirigir al login si no hay sesión
        }

        session(['id_restaurante' => $request->id_restaurante]);
        return view('restaurantes.ver');
    }

    public function mostrarinforestaurante()
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('id')) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $id = session('id');
        $id_restaurante = session('id_restaurante');

        $restaurante = Restaurante::select([
            'restaurantes.*',
            DB::raw('COALESCE(ROUND(AVG(valoraciones.valoracion), 2), 0) AS media_valoracion'),
            DB::raw('COUNT(valoraciones.valoracion) AS total_valoracion'),
        ])
            ->leftJoin('valoraciones', 'restaurantes.id', '=', 'valoraciones.id_restaurante')
            ->groupBy('restaurantes.id')
            ->where('restaurantes.id', '=', $id_restaurante)
            ->get();

        $valoraciones = Valoracion::join('usuarios as u', 'u.id', '=', 'valoraciones.id_usuarios')
            ->select('valoraciones.*', 'u.nombre')
            ->where('id_restaurante', $id_restaurante)
            ->orderBy('valoraciones.id', 'asc')
            ->get();

        $redsocial = restaurante_red_social::join('redes_sociales as re', 're.id', '=', 'restaurante_red_social.id_red_social')
            ->join('restaurantes as r', 'r.id', '=', 'restaurante_red_social.id_restaurante')
            ->select('url', 'platforma')
            ->where('id_restaurante', $id_restaurante)
            ->get();

        // print_r($redsocial);

        return response()->json(['restaurante' => $restaurante, 'valoraciones' => $valoraciones, 'id' => $id, 'redsocial' => $redsocial]);
    }

    public function opinarform(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('id')) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $id_usuario = session('id');
        $id_restaurante = session('id_restaurante');

        if (isset($request->id)) {
            $resultado = Valoracion::find($request->id);
            $resultado->valoracion = $request->estrellas;
            $resultado->comentario = $request->comentario;
            $resultado->id_usuarios = $id_usuario;
            $resultado->id_restaurante = $id_restaurante;
            $resultado->save();
            echo "ok";
        } else {
            $resultado = new Valoracion();
            $resultado->valoracion = $request->estrellas;
            $resultado->comentario = $request->comentario;
            $resultado->id_usuarios = $id_usuario;
            $resultado->id_restaurante = $id_restaurante;
            $resultado->save();
        }
        echo "ok";
    }

    public function restaurantesMejorValorados()
    {
        $restaurantesMejorValorados = Restaurante::select(
            'restaurantes.id',
            'restaurantes.nombre',
            'restaurantes.descripcion',
            'restaurantes.precio_medio',
            'restaurantes.img',
            DB::raw('COALESCE(ROUND(AVG(valoraciones.valoracion), 2), 0) AS media_valoracion')
        )
            ->leftJoin('valoraciones', 'restaurantes.id', '=', 'valoraciones.id_restaurante')
            ->groupBy('restaurantes.id', 'restaurantes.nombre', 'restaurantes.descripcion', 'restaurantes.precio_medio', 'restaurantes.img')
            ->orderByDesc('media_valoracion')
            ->limit(3)
            ->get();

        return view('dashboard', compact('restaurantesMejorValorados'));
    }

    public function datosopinar(Request $request)
    {
        $datosvaloracion = Valoracion::find($request->input('id'));
        return response()->json($datosvaloracion);
    }

    public function eliminaropinion(Request $request)
    {
        $id = $request->input('id');
        $resultado = Valoracion::find($id);
        $resultado->delete();
        echo "ok";
    }
}
