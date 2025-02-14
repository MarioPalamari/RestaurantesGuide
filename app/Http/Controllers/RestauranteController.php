<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Valoracion;
use Illuminate\Support\Facades\DB;

class RestauranteController extends Controller
{
    public function restaurantes()
    {
        $restaurantes = Restaurante::select(
            'restaurantes.id',
            'restaurantes.nombre',
            'restaurantes.descripcion',
            'restaurantes.precio_medio',
            'restaurantes.img',
            DB::raw('COALESCE(ROUND(AVG(valoraciones.valoracion), 2), 0) AS media_valoracion')
        )
            ->leftJoin('valoraciones', 'restaurantes.id', '=', 'valoraciones.id_restaurante')
            ->groupBy('restaurantes.id', 'restaurantes.nombre')
            ->orderByDesc('media_valoracion')
            ->paginate(5);

        // $restaurantes = Restaurante::select(
        //     'restaurantes.*',
        //     'e.*',
        //     DB::raw('ROUND(AVG(v.valoracion), 2) AS media_valoracion')

        // )
        //     ->join('valoraciones as v', 'v.id_restaurante', '=', 'restaurantes.id')
        //     ->join('restaurante_etiqueta as re', 're.id_restaurante', '=', 'restaurantes.id')
        //     ->join('etiquetas as e', 'e.id', '=', 're.id_etiqueta')
        //     ->groupBy('restaurantes.id')
        //     ->get();

        // print_r($restaurantes);

        return view('restaurantes.restaurantes', compact('restaurantes'));
    }

    public function inforestaurante($nombre, Request $request)
    {
        $restaurante = Restaurante::find($request->id_restaurante);
        $valoreaciones = Valoracion::all()->where('id_restaurante', $request->id_restaurante);
        return  view('restaurantes.ver', compact('restaurante', 'valoreaciones'));
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
    
    
}
