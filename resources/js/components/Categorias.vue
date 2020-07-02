<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Categorías
                        <button type="button" class="btn btn-secondary" @click="abrirModal('categoria', 'registrar')" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="titulo">titulo</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" >
                                    <button type="submit" class="btn btn-primary" @click="listarCategorias(1, buscar, criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>titulo</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in lCategorias" :key="categoria.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('categoria','actualizar',categoria)" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="categoria.estado">
                                             <button type="button" class="btn btn-danger btn-sm"  @click="desactivarCategoria(categoria.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                        </template>
                                         <template v-else>
                                             <button type="button" class="btn btn-info btn-sm"  @click="activarCategoria(categoria.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                        </template>
                                       
                                    </td>
                                    <td v-text="categoria.titulo"></td>
                                    <td v-text="categoria.descripcion"></td>
                                    <td v-if="categoria.estado">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="titulo" class="form-control" placeholder="Nombre de categoría">
                                        <span class="help-block">(*) Ingrese el nombre de la categoría</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Enter Email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="text-center text-error">
                                        <div v-show="errorCategoria" class="form-group row">
                                        <ul>
                                                <li v-for="error in erroresCategoria" :key="error">
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
                            <button type="button" class="btn btn-primary" v-if="tipoAccion===1" @click="registrarCategoria()">Guardar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoAccion===2" @click="actualizarCategoria()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Categoría</h4>
                            <button type="button" class="close"  aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de eliminar la categoría?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" >Cerrar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
import Swal from 'sweetalert2'
    export default {
      
        data(){
            return {
                categoria_id:0,
                titulo: '',
                descripcion: '',
                lCategorias: [],
                modalito: 0,
                tituloModal: '',
                tipoAccion:0,
                errorCategoria: 0,
                erroresCategoria: [],
                buscar:'',
                criterio:'titulo',
                pagination:{
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,

                },
                offset: 3
              

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
            listarCategorias(page, buscar, criterio){
                            let me=this;

                axios.get('/categorias?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio).then(
                    function(response){
                        me.lCategorias = response.data.categorias.data;
                        me.pagination = response.data.pagination;
                        console.log(response.data);
                    }).catch(function(error){
                        console.log(error);
                    })
            },

            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarCategorias(page, buscar, criterio);
            },

            registrarCategoria(){
                
                if(this.validarErrores()){
                    return;
                }
                let me=this;
                axios.post('/categorias', {
                    'titulo': this.titulo,
                    'descripcion': this.descripcion
                    
                }).then(function(response)
                {
                    me.cerrarModal();
                    me.listarCategorias(1,'','titulo');
                  
                }).catch(function(error){
                    console.log(error);
                });
            },

            actualizarCategoria(){
                 if(this.validarErrores()){
                    return;
                }
                let me=this;
                let regCorr={
                     'titulo':this.titulo,
                     'descripcion': this.descripcion,
                     'id': this.categoria_id
                };
                let url='categorias/'+this.categoria_id;
                axios.put(url, {
                     'titulo':this.titulo,
                     'descripcion': this.descripcion,
                     'id': this.categoria_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarCategorias();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se Actualizo Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        });

                }).catch(function(error){
                    console.log(error);
                });

            },

            desactivarCategoria(id){
                console.log(id);
                let url='categorias/desactivar/' + id;
                let me=this;
                Swal.fire({
                                title: 'Estas seguro?',
                                text: "Estas por desactivar la categoria!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, Desactivalo!'
                                }).then((result) => {
                                if (result.value) {
                                    axios.put(url).then(function(response){

                                   
                                    Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    );
                                    me.listarCategorias();
                                   });
                                }
                            });
            },

            activarCategoria(id){
                let url='categorias/activar/'+id;
                let me=this;
                axios.put(url).then(function(response){
                    Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Activacion Exitosa',
                                    showConfirmButton: false,
                                    timer: 1500
                              });
                              me.listarCategorias();
                })
            },
            validarErrores(){
                this.errorCategoria=0;
                this.erroresCategoria=[];

                if(!this.titulo) this.erroresCategoria.push('El titulo no puede ir vacio');

                if(!this.descripcion) this.erroresCategoria.push('La descripcion no puede ir vacia');

                if(this.erroresCategoria.length) this.errorCategoria=1;

                return this.errorCategoria;
            },
            cerrarModal(){

                this.modalito=0;
                this.tipoAccion=0;
                this.titulo='';
                this.descripcion='';
                this.errorCategoria=0;
                this.categoria_id=0;
                this.erroresCategoria=[];
            
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case 'categoria':
                    {
                        switch(accion){
                            case 'registrar':
                                {
                                   this.modalito = 1;
                                   this.titulo='';
                                   this.descripcion='';
                                   
                                   this.tituloModal='Registrar Categoria';
                                   this.tipoAccion=1;
                                   break;
                                }
                            case 'actualizar':
                                {
                                   this.modalito = 1;
                                   this.categoria_id=data.id;
                                   this.titulo=data.titulo;
                                   this.descripcion=data.descripcion;
                                   
                                   this.tituloModal='Actualizar Categoria';
                                   this.tipoAccion=2;
                                   break;
                                }

                    }
                }
                }
            }
        },
          mounted() {
            this.listarCategorias(1, this.buscar, this.criterio);
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