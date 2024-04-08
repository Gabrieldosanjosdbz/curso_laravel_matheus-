<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
      'items' => 'array'   //sintaxe do laravel para dizer que determinada coluna será um array
    ];

    protected $dates = ['date'];    //dizendo pro model que o campo "date" no banco é uma data

    protected $guarded = [];      // To dizendo que tudo que for enviado pelo post pode ser atualizado sem problema 

    public function user(){
      return $this->belongsTo("App\Models\User");
    }

    public function users() {
      return $this->belongsToMany('App\Models\User');
    }

}
