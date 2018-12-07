<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Programacao;
use App\Models\Noticia;


class ConteudoController extends Controller
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
         $return['menus'] = 'conteudo';

         $noticia = new Noticia();
         $params = ['limit' => 3];
         $return['banners'] = $noticia->siteBannersConteudos($params);
         $programacao = new Programacao();
         $params = ['limit' => 9];
         $return['eventos'] = $programacao->siteEventos($params);
         $categorias = new Categoria();
         $return['categorias'] = $categorias->all();

         $noticia = new Noticia();
         $params = ['limit' => 6];
         $return['noticias'] = $noticia->siteNoticias($params);

         return view('conteudo')->withReturn($return);
     }

}
