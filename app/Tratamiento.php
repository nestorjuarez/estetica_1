<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $fillable = ['descripcion','condicion'];

    public function detalle_trata(){
       return $this->hasMany('App\Detalle_trata');
    }
}
