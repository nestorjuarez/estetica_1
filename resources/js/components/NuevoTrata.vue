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
                        <i class="fa fa-user"></i> PACIENTES
                       
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
                        <table class="table table-bordered table-striped table-sm" id="mitabla">
                            <thead>
                                <tr>
                                  
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Edad</th>
                                    <th>F.Nacimiento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="paciente in lPacientes" :key="paciente.id" v-show="paciente.condicion">
                                    
                                    <td v-text="paciente.nombre"></td>
                                    <td v-text="paciente.apellido"></td>
                                    <td v-text="paciente.edad"></td>
                                    <td v-text="paciente.fecha_nac"></td>
                                    
                                    <td>
                                         <button class="btn btn-info btn-sm" @click="elegirnombre(paciente)"><i class="icon-check"></i></button>
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
                <div class="card">
                    <div class="card-header">
                        <div class="form row mb-2">
                            <div class="col-7">
                                <select class="form-control" v-model="idservicio">
                                    <option value="0" disable>Selecciones</option>
                                    <option v-for="servicio in lservicios" :key="servicio.id" :value="servicio.id" v-text="servicio.descripcion"></option>
                                </select>
                               <!-- <input type="text" class="form-control" placeholder="nombre del Servicio" v-model="descripcion"> -->
                            </div>
                            <div class="col-5">
                                <input type="number" class="form-control" placeholder="Costo" v-model="valor_total" step="0.01">
                            </div>
                        </div>
                        <div class="form-group  row border">
                            <div class="col-md-5">
                                <div class="input-group mt-2 ">
                                  <input type="text" class='form-control' v-model="filter" placeholder="Buscar zonas">
                                   <div class="input-group-append mt-2">
                                     <button class="btn btn-primary btn-outline-secondary" @click="mostrartratas()">...</button>
                                   </div>
                                  
                                </div>
                               
                            </div>
                            <div class="col-md-5">
                                <div class="form-group mt-2">
                                    <label for="dafsf" class="form-control" v-text="nombrecompleto"></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mt-2" style="background: rgb(191, 242, 206);">
                                    <label for="adsf" v-text="verfecha" class="form-control"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Tratamiento</th>
                                    <th>Sesiones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(tratar, index) in dataTratamientos">
                                    <td v-text="tratar.descripcion"></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="borrarDataTrata(index)"><i class="icon-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="registrarTratamiento()">Registrar Tratamiento</button>
                    </div>
                </div>
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
                           <b-table
                           ref="selectableTable"
                           striped hover
                           :items="lTratamientos"
                           :fields="fields"
                           :filter="filter"
                           selectable
                           select-mode="single"
                           @row-selected="onRowSelected"
                           responsive="sm"
                           >
                               

                            <template v-slot:cell(selected)="{ rowSelected }">
                                <template v-if="rowSelected">
                                    <span aria-hidden="true">&check;</span>
                                    <span class="sr-only">Selected</span>
                                </template>
                                <template v-else>
                                    <span aria-hidden="true">&nbsp;</span>
                                    <span class="sr-only">Not selected</span>
                                </template>
                            </template>
                          </b-table>   

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
                idTratamiento:0,
                idservicio:0,
                filter:'',
                nombre: '',
                apellido:'',
                descripcion: '',
                fecha: new Date(),
                verfecha:'',
                edad: 0,
                fecha_nac:'',
            
                nombrecompleto:'Elegir un Nombre',
                lPacientes: [],
                fields: ['selected','id','descripcion'],
              
                modalito: 0,
                tituloModal: '',
                tipoAccion:0,
                valor_total:0,
                dataTratamientos: [],
                lservicios:[],
                lTratamientos:[],
                selected: [],
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
               onRowSelected(items) {
                    this.selected = items;

                    if(this.selected.length != 0) 
                     {
                   
                        this.dataTratamientos.push(this.selected[0]);
                        this.clearSelected();
                     }
                    this.cerrarModal();
             },

             clearSelected(){
                  this.$refs.selectableTable.clearSelected();
             },
            getTratamientos(){
                let me=this;
                axios.get('/tratamientos/seleccionar').then(response => {

                    me.lTratamientos= response.data.tratamientos;
                }).catch(function(error){
                    console.log(error);
                });
            },

            getServicios(){
                 let me=this;
                axios.get('servicios').then(response => {
                    me.lservicios = response.data;
                }).catch(error => {
                    console.log('no hizo query servicios');
                });
            },


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

           elegirnombre(paciente){
               this.paciente_id=paciente.id;
                this.nombrecompleto=paciente.apellido + ' ' + paciente.nombre;
           },

           devolverFecha(){
               var options = { year: 'numeric', month: 'long', day: 'numeric'};
               this.verfecha=this.fecha.toLocaleDateString("es-ES", options);
           },
           
            cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarPacientes(page, buscar, criterio);
            },

            registrarSesion(){

               this.modsesion=1; 
            },
        

      

            

         
            cerrarModal(){

                this.modalito=0;
                this.modsesion=0;
                this.selected=[];
               
                // this.clearSelected();

                // this.tipoAccion=0;
                // this.nombre='';
                // this.apellido='';
                // this.edad=0;
                // this.fecha_nac='';
                // this.errorPaciente=0;
                // this.paciente_id=0;
                // this.erroresPaciente=[];
            
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
            },

            mostrartratas(){

                this.modalito=1;
            },

            borrarDataTrata(index){
                this.dataTratamientos.splice(index, 1);

            },

            registrarTratamiento(){
                let me=this;
                axios.post('/ventas',{
                    'idpaciente': this.paciente_id,
                    'idservicio': this.idservicio,
                    'valor_total': this.valor_total,
                    'data': this.dataTratamientos

                }).then(response => {
                     Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro exitoso',
                        showConfirmButton: false,
                        timer: 1500
                        });
                console.log(response.data);
                me.dataTratamientos = [];
                me.descripcion = '';
                me.paciente_id = 0;

                }).catch(error => {
                    console.log('Se produjo un error en la carga');
                })

            },

           

        },
          mounted() {
            this.listarPacientes(1, this.buscar, this.criterio);
            this.getTratamientos();
            this.getServicios();
            this.devolverFecha();
        }

    }
</script>

<style>

    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        top:50%;
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