<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
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
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','categorias.titulo as nombre_categoria','articulos.precio_venta',
            'articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id','desc')->paginate(5);
            
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','categorias.titulo as nombre_categoria','articulos.precio_venta',
            'articulos.stock','articulos.descripcion','articulos.condicion')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulos.id','desc')->paginate(5);

        }

        
        
        return [ 

            
                'pagination' => [
                    'total'         => $articulos->total(),
                    'current_page'  => $articulos->currentPage(),
                    'per_page'      => $articulos->perPage(),
                    'last_page'     => $articulos->lastPage(),
                    'from'          => $articulos->firstItem(),
                    'to'            => $articulos->lastItem(),  
                ],

            
            
               'articulos' => $articulos

        ];
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
        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria;
        // $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion='1';
        $articulo->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
            $articulo = Articulo::findOrFail($request->id);
            $articulo->idcategoria = $request->idcategoria;
            // $articulo->codigo = $request->codigo;
            $articulo->nombre = $request->nombre;
            $articulo->precio_venta = $request->precio_venta;
            $articulo->stock = $request->stock;
            $articulo->descripcion = $request->descripcion;
           

            $articulo->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        //
    }

    public function activar($id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->condicion='1';
        $articulo->save();
    }

    public function desactivar($id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->condicion='0';
        $articulo->save();
    }
}
