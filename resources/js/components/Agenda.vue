<template>
  
    <div class="main">
        <div class="container-fluid">

            <h3>Agenda de turnos</h3>
            <div >
            <FullCalendar
                    :options='calendarOptions'
                >
                <!-- <template v-slot:eventContent='arg'>
                <b>{{ arg.timeText }}</b>
                <i>{{ arg.event.title }}</i>
                </template> -->
            </FullCalendar>

            </div>

               <b-modal v-model="modalShow" hide-backdrop content-class="shadow" size='lg'
               
               >
                
                     <div class="form-group row">
                            <div class="input-group mt-2">
                               <div class="input-group-prepend">
                                  <span class="input-group-text pr-1" id="inputGroup-sizing-default">Nombre</span>
                               </div>
                               <input type="text" v-model="nombrePac" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                             <div class="input-group mt-2">
                               <div class="input-group-prepend">
                                  <span class="input-group-text pr-1" id="inputGroup-sizing-default">Apellido</span>
                               </div>
                               <input type="text" v-model="apellidoPac" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                      </div>

                      <!-- <div class="form-control">
                         <b-table
                          striped hover
                          :items="lpacientes"
                          :fields="fields_pacientes"
                          :filter="filtros"
                          :current-page="currentPage"
                          :per-page="perPage"
                          selectable
                          select-mode="single"
                          @row-selected="selecPacientes"
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
                      </div> -->

                 

              
              </b-modal>

           

        </div>
        
        
    </div>  
     
    
  
</template>


<script>
import Swal from 'sweetalert2'

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import { INITIAL_EVENTS, createEventId } from './event-utils'

import locale from '@fullcalendar/core/locales/es'

export default {

  components: {
    FullCalendar // make the <FullCalendar> tag available
  },

  data: function() {


    return {
       
       modalShow:false,
       nombrePac:'',
       apellidoPac:'',
       lpacientes:[],
       fields_pacientes:['selected','id','apellido','nombre'],
       currentPage:1,
       perPage:5,
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin // needed for dateClick
        ],
        locales:'es',
        headerToolbar: {
          left: 'prev,next,today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText:{
            today:    'Hoy',
            month:    'Mes',
            week:     'Semana',
            day:      'dia',
            list:     'list'

        },
        initialView: 'dayGridMonth',
        slotDuration:'00:15:00',
       
        eventSources: 
          {
            url: 'http://localhost:8000/eventos/listar',

            // display: 'background',
            
            textColor: 'white',
            color: 'yellow',
            backgroundColor:'blue'
          },
       
         // alternatively, use the `events` setting to fetch from a feed
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        select: this.handleDateSelect,
        eventClick: this.handleEventClick,
        eventsSet: this.handleEvents,
    

        /* you can update a remote database when these fire:
        eventAdd:
        eventChange:
        eventRemove:
        */
      },
      currentEvents: []
    }
  },

 
  methods: {

     selecPacientes(items){
                 let me=this;
                 if(items.length){
                     this.modalShow = false;
                    console.log(items[0].nombre);
                 }
     },


   

    handleWeekendsToggle() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
    },

  

    handleDateSelect(selectInfo) {
    
      let title = prompt('Nombre del Paciente')
    
      let calendarApi = selectInfo.view.calendar

      

      calendarApi.unselect() // clear date selection
     
      if (title) {

         axios.
          post('/eventos',{
            'title': title, 
            'start': selectInfo.startStr,
            'end': selectInfo.startStr
            }).
          then(response => {
            console.log(response.data);
              alert('Registro de turno exitoso');
          }).
          catch(error => {
              console.log('error en grabado de datos');
          });

        calendarApi.addEvent({
          id: createEventId(),
          title,
          start: selectInfo.startStr,
          end: selectInfo.endStr,

         
          // allDay: selectInfo.allDay
        });
      }
         
    },

    handleEvents(events){
      this.currentEvents=events;
      console.log();
    },

    handleEventClick(clickInfo) {

        // alert('elegido');
      Swal.fire({
                  title: 'Are you sure?',
                  text: "Estas Seguro de borrar el evento del paciente :" + clickInfo.event.title,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).
                then((result) => {
                    if (result.value) {
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    }
                  });


      // if (confirm(`Are you sure you want to delete the event '${clickInfo.event.extendedProps.idpaciente}'`)) {
      //   clickInfo.event.remove()
      // }
    },

    getPacientes(){
                            let me=this;
                let url='/pacientes';
                axios.get(url).then(
                    function(response){
                        me.lpacientes = response.data.pacientes.data;

                        // console.log(response.data.pacientes.data);
                    }).catch(function(error){
                        console.log(error);
                    })
            
    }

  },
  
  mounted(){
    this.getPacientes();
    // this.cargarEventos();
  }
    

    
  

 
}
</script>


<style lang='css'>

h2 {
  margin: 0;
  font-size: 16px;
}

ul {
  margin: 0;
  padding: 0 0 0 1.5em;
}

li {
  margin: 1.5em 0;
  padding: 0;
}

b { /* used for event dates/times */
  margin-right: 3px;
}

.demo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.demo-app-sidebar {
  width: 300px;
  line-height: 1.5;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}

.demo-app-sidebar-section {
  padding: 2em;
}

.demo-app-main {
  flex-grow: 1;
  padding: 3em;
}

.fc { /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}



</style>