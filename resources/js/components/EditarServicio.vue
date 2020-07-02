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
                        <i class="fa fa-user"></i> Servicio/Paciente
                       
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="input-group mt-2">
                                <input type="text" v-model="filtros" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-outline-secondary" @click="getVentrata">...</button>
                                </div>
                            </div>
                        </div>
                        
                         <b-table
                          striped hover
                          :items="lVentrata"
                          :fields="fields_ventrata"
                          :filter="filtros"
                          :current-page="currentPage"
                          :per-page="perPage"
                          selectable
                          select-mode="single"
                          @row-selected="selecVentrata"
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
                    <template>
                        <div>
                             <b-col sm="7" md="6" class="my-1">
                                <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="fill"
                                    size="sm"
                                    class="my-0"
                                  
                                   
                                ></b-pagination>
                            </b-col>

                        </div>
                    

                    </template>
                   
                      
                     
                    
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
                                        <button class="btn btn-danger btn-sm" @click="borrarZonas(tratar, index)"><i class="icon-trash"></i></button>
                                        <button class="btn btn-info btn-sm"><i class="icon-plus"> Sesiones</i></button>
                                        <button class="btn btn-success btn-sm"><i class="icon-eye"> Sesiones</i></button>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="registrarTratamiento()">Actualizar Tratamiento</button>
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

    export default {
      
        data(){
            return {
                paciente_id:0,
                idTratamiento:0,
                idVentrata:0,
                idservicio:0,
                filter:'',
                filtros:'',
                nombre: '',
                apellido:'',
                descripcion: '',
                fecha: new Date(),
                verfecha:'',
                edad: 0,
                fecha_nac:'',
            
                nombrecompleto:'Elegir un Nombre',
                lVentrata: [],
                fields: ['selected','id','descripcion'],
                fields_ventrata: ['selected','id','apellido','nombre','descripcion','fecha','valor','estado'],
              
                modalito: 0,
                tituloModal: '',
                tipoAccion:0,
                valor_total:0,
                dataTratamientos: [],
                lTratamientos:[],
                lservicios:[],
                selected: [],
                buscar:'',
                criterio:'nombre',
                totalRows:0,
                currentPage:1,
                perPage:5,
              

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
                        // aca hacemos el axios reemplazamos dataTratamientos
                        let me=this;
                        axios.post('/detalles',{
                            'idventrata': me.idVentrata,
                            'data': me.selected[0]
                        }).then(response => {
                            alert('Tratamiento registrado exitosamente');
                            console.log(response.data);

                        }).catch(error => {

                            console.log('no paso nada con la query');
                        });
                        // alert(this.idVentrata);
                        this.dataTratamientos.push(this.selected[0]);
                        this.clearSelected();
                     }
                    this.cerrarModal();
             },

             selecVentrata(items){
                 let me=this;
                 if(items.length){
                     
                     this.nombrecompleto=items[0].nombre + ' ' + items[0].apellido;
                     this.idservicio=items[0].idservicio;
                     this.valor_total = items[0].valor;
                     this.idVentrata=items[0].id;

                    axios('/detalles?id=' + items[0].id).then(response => {
                        // aca vamos a llenar dataTratamientos 
                    
                        me.dataTratamientos=response.data;
                    }).catch(error => {
                        console.log('no se hizo la query');
                    })
                 }
             },

             clearSelected(){
                  this.$refs.selectableTable.clearSelected();
             },

             borrarZonas(zonas, index){
                     let urldet='detalles/' + zonas.id;
                     let me=this;
                        console.log(zonas.id);
                      Swal.fire({
                                title: 'Estas seguro?',
                                text: "Estas por elimanar la zona",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, Eliminarlo!'
                                }).then((result) => {
                                if (result.value) {
                                     console.log(urldet);
                                     axios.delete(urldet).then(response=>{
                                        console.log(response.data);
                                   
                                    Swal.fire(
                                    'Eliminado!',
                                    'La zona se ha Eliminado.',
                                    'success'
                                    );
                                    this.getTratamientos();
                                    me.dataTratamientos.splice(index, 1);

                                    // me.listarArticulos(1,'', 'nombre');
                                   }).catch(error => {
                                       console.log('no elimino nada');
                                   });
                                }
                            });
                
             },

            getVentrata(){
                let me=this;
                let mid=0;
                axios.get('/ventas').then(response => {
                    
                    me.lVentrata = response.data;
                    // console.log(me.lVentrata);
                    me.totalRows=response.data.length;
                    
                  
                }).catch(error => {
                    console.log('error de lectura axios');
                })
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
         

          

           devolverFecha(){
               var options = { year: 'numeric', month: 'long', day: 'numeric'};
               this.verfecha=this.fecha.toLocaleDateString("es-ES", options);
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

       

         

        },
          mounted() {
            this.getVentrata();
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
        top:10%;
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