<?php

namespace App\Http\Controllers;

use App\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request != ''){
          $criterio=$request->criterio;
          $buscar=$request->buscar;

        
        if ($request->buscar==''){
            $pacientes = Paciente::paginate(5);
        }else{
            $pacientes= Paciente::where($criterio, 'like', '%'.$buscar.'%')->paginate(5);
        }

        
        return [ 

            
                'pagination' => [
                    'total'         => $pacientes->total(),
                    'current_page'  => $pacientes->currentPage(),
                    'per_page'      => $pacientes->perPage(),
                    'last_page'     => $pacientes->lastPage(),
                    'from'          => $pacientes->firstItem(),
                    'to'            => $pacientes->lastItem(),  
                ],

            
            
               'pacientes' => $pacientes,

        ];

       }else{
        $pacientes = Paciente::all();

        return $paceintes;
       }
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
        $paciente = new Paciente();
        $paciente->nombre = $request->nombre;
        $paciente->apellido = $request->apellido;
        $paciente->edad = $request->edad;
        $paciente->fecha_nac = $request->fecha_nac;

        $paciente->condicion=true;
        $paciente->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit(Paciente $paciente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $paciente = Paciente::findOrFail($request->id);
        $paciente->nombre = $request->nombre;
        $paciente->apellido=$request->apellido;
        $paciente->edad = $request->edad;
        $paciente->fecha_nac=$request->fecha_nac;
        $paciente->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        //
    }


    public function activar($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->condicion=true;
        $paciente->save();
    }

    public function desactivar($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->condicion=false;
        $paciente->save();
    }
}
