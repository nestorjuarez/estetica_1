<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventrata extends Model
{
    protected $fillable=['id','idpaciente','idservicio','fecha','valor','condicion','estado'];

    public function paciente(){
        return $this->belongsTo('App\Paciente');
    }

    public function detalle_trata(){
        return $this->hasMany('App\Detalle_trata');
    }
}
