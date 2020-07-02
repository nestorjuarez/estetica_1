<?php

namespace App\Http\Controllers;

use App\Detalle_trata;
use App\Tratamiento;
use Illuminate\Http\Request;

class DetalleTrataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $detalle = Detalle_trata::join('idtratamiento','=','tratamientos.id')
        // ->select('detalle_tratas.idventrata','detalle_tratas.idtratamiento','tratamientos.descripcion','tratamientos.id')
        // ->where('idventrata', $request->id)
        // ->get();
        
        $detalle = Detalle_trata::join('tratamientos', 'detalle_tratas.idtratamiento','=','tratamientos.id')
        ->select('detalle_tratas.id','tratamientos.descripcion','detalle_tratas.idventrata','detalle_tratas.condicion','detalle_tratas.idtratamiento')
        ->where('idventrata','=',$request->id)
        ->get();
        return $detalle;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $detalle_trata = new Detalle_trata();
        $detalle_trata->idventrata = $request->idventrata;
        $detalle_trata->idtratamiento = $request->data['id'];
        $detalle_trata->condicion=1;
        $detalle_trata->save();


        return  $detalle_trata;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\detalle_trata  $detalle_trata
     * @return \Illuminate\Http\Response
     */
    public function show(detalle_trata $detalle_trata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\detalle_trata  $detalle_trata
     * @return \Illuminate\Http\Response
     */
    public function edit(detalle_trata $detalle_trata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\detalle_trata  $detalle_trata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, detalle_trata $detalle_trata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\detalle_trata  $detalle_trata
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Detalle_trata::destroy($id);
        
    }
}
