<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantesAdmin extends Controller
{
    public function ShowAdminRestaurantes(){
        return view('admin.admin-restaurante');
    }
}
