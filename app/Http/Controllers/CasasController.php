<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Programacao;
use App\Models\Casa;


class CasasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $return = [];
         $return['menus'] = 'lugares';

         $casa = new Casa();
         $params = ['limit' => 3];
         $return['banners'] = $casa->siteBannersCasas($params);
         $programacao = new Programacao();
         $params = ['limit' => 9];
         $return['eventos'] = $programacao->siteEventos($params);
         $categorias = new Categoria();
         $return['categorias'] = $categorias->all();
         $casa = new Casa();
         $params = ['limit' => 6];
         $return['casas'] = $casa->siteCasas($params);

         return view('casas')->withReturn($return);
     }

}
