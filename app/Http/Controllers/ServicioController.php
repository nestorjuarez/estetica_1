<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;
use App\Detalle_trata;

class ServicioController extends Controller
{
    public function index(){

        $servicios = Servicio::All();
        return $servicios;
    }



    public function destroy($id){

        Servicio::destroy($id);
    }
}
