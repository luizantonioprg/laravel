<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $fillable = [
        'codigo', 'titulo','id_categoria',
    ];

    public function category(){
        return $this->belongsTo('App\Category','id_categoria');
    }
    
}
