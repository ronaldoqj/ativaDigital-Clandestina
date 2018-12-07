<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Casa;
use App\Models\Programacao;

class CasaController extends Controller
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
    public function index(Request $request, $id = null, $title = null)
    {
        $return = [];
        $return['menus'] = '';

        $casa = new Casa();
        $return['casa'] = $casa->siteCasa($id);
        $return['galeria'] = $casa->siteCasaGaleria($id);

        $programacao = new Programacao();
        $params = [
                    'limit' => 6,
                    'PesquisaRelacionada' => [
                                            'id' => $id,
                                            'tabela' => 'casas'
                                          ]
                  ];
        $return['eventos'] = $programacao->siteEventos($params);

        $filtrosMesesDias = new Programacao();
        $return['filtrosMesesDias'] = $filtrosMesesDias->filtrosMesesDias();

        return view('casa')->withReturn($return);
    }
}
