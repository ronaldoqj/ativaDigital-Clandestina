<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Programacao;
use App\Models\Noticia;
use App\Models\Casa;
use App\Models\Parceiro;

class WelcomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $return = [];
        $return['menus'] = 'home';

        $programacao = new Programacao();
        $params = ['limit' => 3];
        $return['banners'] = $programacao->siteBannersHome($params);
        $return['meses'] = $programacao->siteMeses();
        // $return['meses'] = $programacao->siteMesesSemVerificarNoBanco();
        $programacao = new Programacao();
        $params = ['limit' => 6];
        $return['eventos'] = $programacao->siteEventos($params);

        $categorias = new Categoria();
        $return['categorias'] = $categorias->all();
        $noticia = new Noticia();
        $params = ['limit' => 6];
        $return['noticias'] = $noticia->siteNoticias($params);
        $casa = new Casa();
        $params = ['limit' => 6];
        $return['casas'] = $casa->siteCasas($params);

        $filtrosMesesDias = new Programacao();
        $return['filtrosMesesDias'] = $filtrosMesesDias->filtrosMesesDias();

        $parceiros = new Parceiro();
        $return['parceiros'] = $parceiros->listParceiros();

        // dd($return['banners']->toArray());

        return view('welcome')->withReturn($return);
    }


    public function ajax_selectEvents(Request $request)
    {
        // Declaração de variaveis
        $return;
        $programacao = new Programacao();
        $params = ['paginacao' => $request->paginacao,
                   'NRegistros' => $request->NRegistros,
                   'mes' => $request->mes,
                   'dia' => $request->dia,
                   'cat' => $request->cat,
                   'search' => $request->search,
                   'PesquisaRelacionada' => json_decode($request->PesquisaRelacionada, true)];
        $return = $programacao->siteEventosAjax($params);

        return $return;
    }

    public function ajax_selectLugares(Request $request)
    {
        // Declaração de variaveis
        $return;

        $programacao = new Programacao();
        $params = ['paginacao' => $request->paginacao,
                   'NRegistros' => $request->NRegistros,
                   'cat' => $request->cat,
                   'search' => $request->search];
        $return = $programacao->siteLugaresAjax($params);

        return $return;
    }

    public function ajax_selectConteudo(Request $request)
    {
        // Declaração de variaveis
        $return;

        $programacao = new Programacao();
        $params = ['paginacao' => $request->paginacao,
                   'NRegistros' => $request->NRegistros,
                   'cat' => $request->cat,
                   'search' => $request->search];
        $return = $programacao->siteConteudoAjax($params);

        return $return;
    }

    public function ajax_registerNewsLetter(Request $request)
    {
        $programacao = new Programacao();
        $return = $programacao->siteRegisterNewsletterAjax($request);

        return $return;
    }

    public function ajax_bannersTops(Request $request)
    {
        $return;

        $programacao = new Programacao();
        $params = ['id' => $request->id,
                   'ativo' => $request->ativo,
                   'table' => $request->table,
                   'column' => $request->column];
        $return = $programacao->siteBannersTopsAjax($request);

        return $return;
    }

    public function ajax_bannersTopsOrders(Request $request)
    {
        $return;

        $programacao = new Programacao();
        $params = ['id' => $request->id,
                   'table' => $request->table,
                   'column' => $request->column,
                   'value' => $request->value];
        $return = $programacao->siteOrderBannersTopsAjax($request);

        return $return;
    }

}
