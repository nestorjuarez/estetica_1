<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use Carbon\Carbon;
use DB;

class EventosController extends Controller
{
    public function index(){
        $eventos = Evento::all();
    
    
        // die($eventos);
        
        return json_encode($eventos);
    }

    public function store(Request $request)
    {
        
        $evento = new Evento();
        $evento->title = $request->title;
        $evento->start = $request->start;
        $evento->end = $request->end;
        $evento->save();
        
        return $request;
    }
}