<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Categoria;


class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $criterio=$request->criterio;
        $buscar=$request->buscar;
        if ($request->buscar==''){
            $categorias = Categoria::paginate(5);
        }else{
            $categorias= Categoria::where($criterio, 'like', '%'.$buscar.'%')->paginate(5);
        }

        
        return [ 

            
                'pagination' => [
                    'total'         => $categorias->total(),
                    'current_page'  => $categorias->currentPage(),
                    'per_page'      => $categorias->perPage(),
                    'last_page'     => $categorias->lastPage(),
                    'from'          => $categorias->firstItem(),
                    'to'            => $categorias->lastItem(),  
                ],

            
            
               'categorias' => $categorias,

        ];
    }


    public function selectCategoria(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('estado','=','1')
        ->select('id','titulo')->orderBy('titulo', 'asc')->get();
        return ['categorias' => $categorias];
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
        $categoria = new Categoria();
        $categoria->titulo = $request->titulo;
        $categoria->descripcion = $request->descripcion;
        $categoria->estado=true;
        $categoria->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function show(Categorias $categorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorias $categorias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->titulo = $request->titulo;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorias $categorias)
    {
        //
    }

    public function activar($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->estado=true;
        $categoria->save();
    }

    public function desactivar($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->estado=false;
        $categoria->save();
    }

   
    

 
}
