<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Sesione extends Model
{
    protected $fillable = ['iddetalle_trata','fecha','frecuencia','cantidad','tiempo'];

    public function detalle_trata(){
      return $this->belognsTo('App\Detalle_trata');
    }
}
