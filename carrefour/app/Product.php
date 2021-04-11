<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'codigo', 'titulo','id_categoria','id_subcategoria','imagem','descricao','valor','tag','status',
    ];

}
