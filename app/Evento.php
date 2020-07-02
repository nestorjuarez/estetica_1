<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['title','color','textcolor','start','end'];
}
