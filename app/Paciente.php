<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable=['nombre','apellido','edad','fecha_nac'];
    
    public function ventrata(){
        return $this->hasMany('App\Ventrata');
    }
}
