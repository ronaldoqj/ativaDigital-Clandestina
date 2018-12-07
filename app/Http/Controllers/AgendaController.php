<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Programacao;


class AgendaController extends Controller
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
         $return['menus'] = 'agenda';

         $programacao = new Programacao();
         $params = ['limit' => 2];
         $return['banners'] = $programacao->siteBannersAgenda($params);
         $return['meses'] = $programacao->siteMeses();
         $programacao = new Programacao();
         $params = ['limit' => 9];
         $return['eventos'] = $programacao->siteEventos($params);
         $categorias = new Categoria();
         $return['categorias'] = $categorias->all();

         $filtrosMesesDias = new Programacao();
         $return['filtrosMesesDias'] = $filtrosMesesDias->filtrosMesesDias();

         return view('agenda')->withReturn($return);
     }

}
