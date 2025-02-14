<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Valoracion;
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

    public function inforestaurante($nombre, Request $request)
    {
        $restaurante = Restaurante::find($request->id_restaurante);
        $valoreaciones = Valoracion::all()->where('id_restaurante', $request->id_restaurante);
        return  view('restaurantes.ver', compact('restaurante', 'valoreaciones'));
    }
}
