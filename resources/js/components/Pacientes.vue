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
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalNuevo">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" id="opcion" name="opcion">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <b-table striped hover :items="arrayPacientes" :fields="fields" 
                        selectable
                        select-mode="single"
                        responsive="sm"
                         
                        >
                             <template v-slot:cell(actions)="row">
                                    <b-btn size="sm" variant="primary" @click="onRowSelected(row.item)">
                                    Editar
                                    </b-btn>
                                    <b-btn size="sm" variant="danger">
                                    Eliminar
                                    </b-btn>

                          </template>
                            <!-- <template v-slot:cell(selected)="{ rowSelected }">
                                <template v-if="rowSelected">
                                    <span aria-hidden="true">&check;</span>
                                    <span class="sr-only">Selected</span>
                                </template>
                                <template v-else>
                                    <span aria-hidden="true">&nbsp;</span>
                                    <span class="sr-only">Not selected</span>
                                </template>
                            </template> -->

                        </b-table>
                       
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
             <b-modal id="modal-1" title="BootstrapVue" class="modal-backdrop fade show" >
                <p class="my-4" v-text="selected.nombre"></p>
            </b-modal>

               
          
            
            <!--Fin del modal-->
          
        </main>
</template>

<script>
    export default {

      data(){
          return {

              arrayPacientes: [],
              fields: ['selected', 'nombre', 'apellido', 'edad', 'fecha_nac', {
                  key: 'actions',
                  label: ''
              }],

              selected: [],
          }
      },

      methods: {

           onRowSelected(items) {
        this.selected = items
             },
          getPacientes(){
              let me=this;
              axios.get('/pacientes').then(function(response){
                  me.arrayPacientes=response.data;
              })
          },

        onRowSelected(items) {
            this.selected = items;
            this.$bvModal.show('modal-1');
            console.log(this.selected.nombre);
        }
    },

        mounted() {
            this.getPacientes();            
        }
    }

</script>
<style>

.modal-backdrop {
   opacity : transparent ;
}
</style>
