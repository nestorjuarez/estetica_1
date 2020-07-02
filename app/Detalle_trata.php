<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_trata extends Model
{
    protected $fillable=['id','idventrata','idtratamiento','condicion'];

    public function ventrata(){

        return $this->belongsTo('App\Ventrata');
    }

    public function tratamiento(){
        return $this->belongsTo('App\Tratamiento');
    }

    public function sesiones(){
        return $this->hasMany('App\Sesione');
    }
}
