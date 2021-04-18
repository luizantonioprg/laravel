<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ExportPDF extends Controller
{
    //
    public function generate(){
         $products = Product::all();
        //$products =Product::where($categoria, $subcategoria)->get();
        $fileName = 'Produtos_Lista.pdf';
        $mpdf = new \Mpdf\Mpdf([
        'margin_left'=> 10,
        'margin_right'=> 10,
        'margin_top'=> 15,
        'margin_bottom'=> 20,
        'margin_header'=> 10,
        'margin_footer'=> 10,

        ]);
        $html = \View::make('pdf.result')->with('products',$products);
        $html = $html->render();
        $mpdf->SetHeader('PDF|LISTA DE PRODUTOS|{PAGENO}');
        $mpdf->SetFooter('This is a footer');
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName,'I');
    }
    public function generateDinamic($categoria,$subcategoria){

        $products =Product::where($categoria, $subcategoria)->get();
        $fileName = 'Produtos_Lista.pdf';
        $mpdf = new \Mpdf\Mpdf([
        'margin_left'=> 10,
        'margin_right'=> 10,
        'margin_top'=> 15,
        'margin_bottom'=> 20,
        'margin_header'=> 10,
        'margin_footer'=> 10,

        ]);
        $html = \View::make('pdf.result')->with('products',$products);
        $html = $html->render();
        $mpdf->SetHeader('PDF|LISTA DE PRODUTOS|{PAGENO}');
        $mpdf->SetFooter('This is a footer');
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName,'I');
    }
}
