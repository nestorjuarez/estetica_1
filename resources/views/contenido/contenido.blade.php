@extends('principal')

@section('contenido')
  <template v-if="menu==0">
      <Agenda></Agenda>
  </template>
  <template v-if="menu==1">
     <Categorias></Categorias>
  </template>
  
 
  <template v-if="menu==2">
     <Articulos></Articulos>

  </template>
  <template v-if="menu==3">
      <Patients></Patients>
  </template>
  <template v-if="menu==4">
     <nuevotrata></nuevotrata>
  </template>
  <template v-if="menu==5">
     <editarservicio></editarservicio>
  </template>
  <template v-if="menu==6">
     lleva a clientes
  </template>
  <template v-if="menu==7">
     lleva a usuarios
  </template>
  <template v-if="menu==8">
     lleva a roles
  </template>
  <template v-if="menu==9">
     lleva a Reporte de Ingresos
  </template>
  <template v-if="menu==10">
     Reporte de Ventas
  </template>
  <template v-if="menu==11">
     LLeva a ayuda
  </template>
  <template v-if="menu==12">
        Lleva a cerca de
   </template>

  @endsection
