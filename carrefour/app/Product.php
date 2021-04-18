<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product extends Model
{
    //
    protected $fillable = [
        'codigo', 'titulo','id_categoria','id_subcategoria','imagem','descricao','valor','tag','status',
    ];
    public function category(){
        return $this->belongsTo('App\Category','id_categoria');
    }
    public function subcategory(){
        return $this->belongsTo('App\SubCategory','id_subcategoria');
    }
    public function getTableColumns(){
        $qry = "SELECT column_name
        FROM information_schema.columns
        WHERE table_name = 'products'
        AND table_schema = 'carrefour'";
        $result = DB::select($qry);
        $result  = $this->transposeData($result);
        return $result;
    }
    public function transposeData($data){
        $result = array();
        foreach($data as $row => $columns){
            foreach($columns as $row2 => $column2){
                $result[$row2][$row] = $column2;
            }
        }
        return $result;

    }
    public function getAll(){
        return collect(DB::select('select * from '.$this->getTable()));
    }

//$users = DB::select('select * from users where id = ?', array(1));
}
