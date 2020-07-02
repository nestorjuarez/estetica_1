<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ventrata;
use App\Detalle_trata;
class VentrataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $buscar=$request->buscar;
        // $criterio=$request->criterio;


            $venta = Ventrata::join('pacientes','ventratas.idpaciente','=','pacientes.id')
            ->join('servicios','ventratas.idservicio','=','servicios.id')
            ->select('ventratas.id','pacientes.nombre','pacientes.apellido','ventratas.idservicio','servicios.descripcion','ventratas.fecha','ventratas.valor','ventratas.condicion','ventratas.estado')
            ->orderBy('pacientes.apellido', 'asc')->get();
            

        // return [ 

            
        //     'pagination' => [
        //         'total'         => $venta->total(),
        //         'current_page'  => $venta->currentPage(),
        //         'per_page'      => $venta->perPage(),
        //         'last_page'     => $venta->lastPage(),
        //         'from'          => $venta->firstItem(),
        //         'to'            => $venta->lastItem(),  
        //     ],

        
        
    //        'venta' => $venta

    // ];

    return $venta;

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
        try {
            DB::beginTransaction();
            $myTime = Carbon::now('America/Argentina/Cordoba');
            $venta = new Ventrata();

            $venta->idpaciente = $request->idpaciente;
            $venta->idservicio = $request->idservicio;
            $venta->fecha = $myTime->toDateTimeString();
            $venta->valor = $request->valor_total;
            $venta->condicion=1;
            $venta->estado=1;
            $venta->save();

            $detalle = $request->data;
            foreach($detalle as $cla=>$det)
            {
                $detalle_trata = new Detalle_trata();
                $detalle_trata->idventrata = $venta->id;
                $detalle_trata->idtratamiento = $det['id'];
                $detalle_trata->condicion=1;
                $detalle_trata->save();


            }
            DB::commit();
            $comu = 'registro exitoso';
        } catch (Exception $e) {
            DB::rollBack();
            $comu='todo mal';
        }

        return $venta;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ventrata  $ventrata
     * @return \Illuminate\Http\Response
     */
    public function show(Ventrata $ventrata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ventrata  $ventrata
     * @return \Illuminate\Http\Response
     */
    public function edit(Ventrata $ventrata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ventrata  $ventrata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ventrata $ventrata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ventrata  $ventrata
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ventrata $ventrata)
    {
        //
    }
}
