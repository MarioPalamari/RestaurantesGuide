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
        // $restaurantes = Restaurante::all();
        // $Valoraciones = Valoracion::all();
        $restaurantes = Restaurante::select(
            'restaurantes.id',
            'restaurantes.nombre',
            'restaurantes.descripcion',
            'restaurantes.precio_medio',
            'restaurantes.img',
            // para evitar SQL injection DB::raw
            DB::raw('COALESCE(ROUND(AVG(valoraciones.valoracion), 2), 0) AS media_valoracion')
        )
            ->leftJoin('valoraciones', 'restaurantes.id', '=', 'valoraciones.id_restaurante')
            ->groupBy('restaurantes.id', 'restaurantes.nombre')
            ->orderByDesc('media_valoracion')
            ->paginate(2);
        // ->get();
        // return view('restaurantes.restaurantes', compact('restaurantes', 'Valoraciones'));
        return view('restaurantes.restaurantes', compact('restaurantes'));
    }

    public function inforestaurante($nombre, Request $request)
    {
        // echo $nombre;
        // echo $request->id_restaurante;
        $restaurante = Restaurante::find($request->id_restaurante);
        // return $restaurantes;
        // return view('cursos.index', ['cursos' => $cursos]);
        return  view('restaurantes.ver', compact('restaurante'));
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
