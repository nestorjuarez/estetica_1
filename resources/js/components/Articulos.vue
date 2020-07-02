<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
               
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
             
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Articulos
                        <button type="button" class="btn btn-secondary" @click="abrirModal('articulo', 'registrar')" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" >
                                    <button type="submit" class="btn btn-primary" @click="listarArticulos(1,buscar, criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in lArticulos" :key="articulo.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('articulo','actualizar',articulo)" >
                                          <i class="icon-pencil pr-2"></i>Editar
                                        </button> &nbsp;
                                        <template v-if="articulo.condicion">
                                             <button type="button" class="btn btn-danger btn-sm"  @click="desactivarArticulo(articulo.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                        </template>
                                         <template v-else>
                                             <button type="button" class="btn btn-info btn-sm"  @click="activarArticulo(articulo.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                        </template>
                                       
                                    </td>
                                    <td v-text="articulo.nombre"></td>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.precio_venta"></td>
                                    <td v-text="articulo.stock"></td>
                                    <td v-text="articulo.descripcion"></td>
                                    <td v-if="articulo.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </td>
                                    <td v-else>
                                        <span class="badge badge-success">inActivo</span>
                                    </td>

                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                </li>
                                <li class="page-item active" v-for="page in pageNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                                </li>
                              
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modalito}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categorias</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.titulo"></option>
                                        </select>
                                        <!-- <span class="help-block">(*) Ingrese el nombre del Articulo</span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del articulo">
                                        <span class="help-block">(*) Ingrese el nombre del Articulo</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripcion del Articulo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Precio de venta</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio_venta" class="form-control" placeholder="Ingrese Precio del Articulo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="Ingrese stock del articulo">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="text-center text-error">
                                        <div v-show="errorArticulo" class="form-group row">
                                        <ul>
                                                <li v-for="error in erroresArticulos" :key="error">
                                                {{error}}
                                            </li>

                                        </ul>
                                     </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoAccion===1" @click="registrarArticulo()">Guardar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoAccion===2" @click="actualizarArticulo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
           
        </main>
</template>

<script>
import Swal from 'sweetalert2'
    export default {
      
        data(){
            return {
                articulo_id:0,
                idcategoria:0,
                nombre_categoria:'',
                precio_venta:0,
                stock:0,
                nombre: '',
                descripcion: '',
                lArticulos: [],
                modalito: 0,
                tituloModal: '',
                tipoAccion:0,
                errorArticulo: 0,
                erroresArticulos: [],
                buscar:'',
                criterio:'nombre',
                pagination:{
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,

                },
                offset: 3,
                arrayCategoria:[],
              

            }

       

        },

        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },

            pageNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pageArray = [];
                while(from <= to){
                    pageArray.push(from);
                    from++;
                }
                return pageArray;
             }
        },

        methods: {
            listarArticulos(page, buscar, criterio){
                            let me=this;

                axios.get('/articulos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio).then(
                    function(response){
                        me.lArticulos = response.data.articulos.data;
                        me.pagination = response.data.pagination;
                    }).catch(function(error){
                        console.log(error);
                    })
            },

            selectCategoria(){
                                let me=this;

                axios.get('categorias/selectCategoria/').then(
                    function(response){
                        me.arrayCategoria = response.data.categorias;
                    }).catch(function(error){
                        console.log(error);
                    })
            },

            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarArticulos(page, buscar, criterio);
            },

            registrarArticulo(){
                
                if(this.validarErrores()){
                    return;
                }
                let me=this;
                axios.post('/articulos', {
                    'nombre': this.nombre,
                    'idcategoria': this.idcategoria,
                    'precio_venta':this.precio_venta,
                    'descripcion': this.descripcion,
                    'stock':this.stock
                    
                    
                }).then(function(response)
                {
                    me.cerrarModal();
                    me.listarArticulos(1, '', 'nombre');
                  
                }).catch(function(error){
                    console.log(error);
                });
            },

            actualizarArticulo(){
                 if(this.validarErrores()){
                    return;
                }
                let me=this;
                let regCorr={
                     'titulo':this.titulo,
                     'descripcion': this.descripcion,
                     'id': this.categoria_id
                };
                let url='articulos/'+this.articulo_id;
                axios.put(url, {
                     'nombre':this.nombre,
                     'idcategoria':this.idcategoria,
                     'precio_venta':this.precio_venta,
                     'stock': this.stock,
                     'descripcion': this.descripcion,
                     'id': this.articulo_id
                }).then(function(response){
                    me.cerrarModal();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se Actualizo Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        });
                      me.listarArticulos(1, '', 'nombre');

                }).catch(function(error){
                    console.log(error);
                });

            },

            desactivarArticulo(id){
                console.log(id);
                let url='articulos/desactivar/' + id;
                let me=this;
                Swal.fire({
                                title: 'Estas seguro?',
                                text: "Estas por desactivar el articulo!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, Desactivalo!'
                                }).then((result) => {
                                if (result.value) {
                                    axios.put(url).then(function(response){

                                   
                                    Swal.fire(
                                    'Desactivado!',
                                    'El articulo ha sido desactivado.',
                                    'success'
                                    );
                                    me.listarArticulos(1,'', 'nombre');
                                   });
                                }
                            });
            },

            activarArticulo(id){
                let url='articulos/activar/'+id;
                let me=this;
                axios.put(url).then(function(response){
                    Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Activacion Exitosa',
                                    showConfirmButton: false,
                                    timer: 1500
                              });
                              me.listarArticulos(1, '', 'nombre');
                })
            },
            validarErrores(){
                this.errorArticulo=0;
                this.erroresArticulos=[];

                if(!this.nombre) this.erroresArticulos.push('El nombre no puede ir vacio');

                if(!this.descripcion) this.erroresArticulos.push('La descripcion no puede ir vacia');

                if(this.erroresArticulos.length) this.errorArticulo=1;

                return this.errorArticulo;
            },
            cerrarModal(){

                this.modalito=0;
                this.tipoAccion=0;
                this.nombre='';
                this.descripcion='';
                this.errorArticulo=0;
                this.articulo_id=0;
                this.idcategoria=0;
                this.stock=0,
                this.precio_venta=0

                this.erroresArticulos=[];
            
            },
            abrirModal(modelo, accion, data=[])
            {
                switch(modelo)
                {
                    case 'articulo':
                    {
                        switch(accion)
                        {
                            case 'registrar':
                                {
                                   this.modalito = 1;
                                   this.nombre='';
                                   this.descripcion='';
                                   this.precio_venta=0;
                                   this.stock=0;
                                   
                                   this.tituloModal='Registrar Articulo';
                                   this.tipoAccion=1;
                                   break;
                                }
                            case 'actualizar':
                                {
                                   this.modalito = 1;
                                   this.articulo_id=data.id;
                                   this.idcategoria=data.idcategoria
                                   this.nombre=data.nombre;
                                   this.precio_venta=data.precio_venta;
                                   this.stock=data.stock;
                                   this.descripcion=data.descripcion;
                                   
                                   this.tituloModal='Actualizar Articulo';
                                   this.tipoAccion=2;
                                   break;
                                
                                }

                        }
                    }
                }
                this.selectCategoria();

            }
        },
          mounted() {
            this.listarArticulos(1, this.buscar, this.criterio);
        }

    }
</script>

<style>

    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color:#4736367a !important;
    }

    .text-error{
        display:flex;
        justify-content: center;
        color:red;
        font-weight: bold;
    }
</style>