<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Captura extends Model
{
     protected $table = 'captura';

     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = ['data','hr_inicio','hr_final', 'sonda', 'latitude1','longitude1','latitude2','longitude2','especie','qtd','embarcacao_id' ];


}
