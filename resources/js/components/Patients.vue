<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
             >
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> PACIENTES
                        <button type="button" class="btn btn-secondary" @click="abrirModal('pacientes', 'registrar')" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">nombre</option>
                                      <option value="apellido">Apellido</option>
                                      <!-- <option value="dni">NroDocumento</option> -->
                                    </select>
                                    <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" >
                                    <button type="submit" class="btn btn-primary" @click="listarPacientes(1, buscar, criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Edad</th>
                                    <th>F.Nacimiento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="paciente in lPacientes" :key="paciente.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('pacientes','actualizar',paciente)" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="paciente.condicion">
                                             <button type="button" class="btn btn-danger btn-sm"  @click="desactivarCategoria(paciente.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                        </template>
                                         <template v-else>
                                             <button type="button" class="btn btn-info btn-sm"  @click="activarCategoria(paciente.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                        </template>
                                       
                                    </td>
                                    <td v-text="paciente.nombre"></td>
                                    <td v-text="paciente.apellido"></td>
                                    <td v-text="paciente.edad"></td>
                                    <td v-text="paciente.fecha_nac"></td>
                                    
                                    <td v-if="paciente.condicion">
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
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Paciente">
                                        <span class="help-block">(*) Ingrese el nombre del Paciente</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Apellido</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido" class="form-control" placeholder="Apellido del Paciente">
                                    </div>
                                </div>
                                
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Fecha de Nacimiento</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fecha_nac" class="form-control" placeholder="Fecha de nacimiento">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Edad</label>
                                    <div class="col-md-9">
                                        <input type="numbre" v-model="edad" class="form-control" placeholder="Ingrese Edad">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="text-center text-error">
                                        <div v-show="errorPaciente" class="form-group row">
                                        <ul>
                                                <li v-for="error in erroresPaciente" :key="error">
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
                            <button type="button" class="btn btn-primary" v-if="tipoAccion===1" @click="registrarPaciente()">Guardar</button>
                            <button type="button" class="btn btn-primary" v-if="tipoAccion===2" @click="actualizarPaciente()">Actualizar</button>
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
                paciente_id:0,
                nombre: '',
                apellido:'',
                edad: 0,
                fecha_nac:'',
                
                lPacientes: [],
                modalito: 0,
                tituloModal: '',
                tipoAccion:0,
                errorPaciente: 0,
                erroresPaciente: [],
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
             },

          
        },

        methods: {
            listarPacientes(page, buscar, criterio){
                            let me=this;
                let url='/pacientes?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(
                    function(response){
                        me.lPacientes = response.data.pacientes.data;
                        me.pagination = response.data.pagination;
                        console.log(response.data);
                    }).catch(function(error){
                        console.log(error);
                    })
            },

           
            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarPacientes(page, buscar, criterio);
            },

            registrarPaciente(){
                
                if(this.validarErrores()){
                    return;
                }
                let me=this;
                axios.post('/pacientes', {
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'edad': this.edad,
                    'fecha_nac': this.fecha_nac
                    
                }).then(function(response)
                {
                    me.cerrarModal();
                    me.listarPacientes(1,'','nombre');
                     Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se Registro Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                        });
                  
                }).catch(function(error){
                    console.log(error);
                });
            },

            actualizarPaciente(){
                 if(this.validarErrores()){
                    return;
                }
                let me=this;
                let regCorr={
                     'titulo':this.titulo,
                     'descripcion': this.descripcion,
                     'id': this.categoria_id
                };
                let url='pacientes/'+this.paciente_id;
                axios.put(url, {
                    'id':this.paciente_id,
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'edad': this.edad,
                    'fecha_nac': this.fecha_nac
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPacientes(1,'','nombre');
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
                let url='pacientes/desactivar/' + id;
                let me=this;
                Swal.fire({
                                title: 'Estas seguro?',
                                text: "Estas por desactivar el paciente!",
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
                                    'Pciente desactivado!!.',
                                    'success'
                                    );
                                    me.listarPacientes(1,'','nombre');
                                   });
                                }
                            });
            },

            activarCategoria(id){
                let url='pacientes/activar/'+id;
                let me=this;
                axios.put(url).then(function(response){
                    Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Activacion Exitosa',
                                    showConfirmButton: false,
                                    timer: 1500
                              });
                              me.listarPacientes(1,'','nombre');
                })
            },
            validarErrores(){
                this.errorPaciente=0;
                this.erroresPeciente=[];

                if(!this.nombre) this.erroresPaciente.push('El titulo no puede ir vacio');

                if(!this.apellido) this.erroresPaciente.push('La descripcion no puede ir vacia');

                if(this.erroresPaciente.length) this.errorPaciente=1;

                return this.errorPaciente;
            },
            cerrarModal(){

                this.modalito=0;
                this.tipoAccion=0;
                this.nombre='';
                this.apellido='';
                this.edad=0;
                this.fecha_nac='';
                this.errorPaciente=0;
                this.paciente_id=0;
                this.erroresPaciente=[];
            
            },
      
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case 'pacientes':
                    {
                        switch(accion){
                            case 'registrar':
                                {
                                   this.modalito = 1;
                                   this.nombre='';
                                   this.apellido='';
                                   this.edad=0;
                                   this.fecha_nac = '';
                                   
                                   this.tituloModal='Registrar Paciente';
                                   this.tipoAccion=1;
                                   break;
                                }
                            case 'actualizar':
                                {
                                   this.modalito = 1;
                                   this.paciente_id=data.id;
                                   this.nombre=data.nombre;
                                   this.apellido=data.apellido;
                                   this.edad=data.edad;
                                   this.fecha_nac=data.fecha_nac;
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
            this.listarPacientes(1, this.buscar, this.criterio);
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