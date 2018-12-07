<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Programacao;

class EventoController extends Controller
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
        if (!is_numeric($id) || !Programacao::find($id)) {
             return redirect()->route('agenda');
        }

        $return = [];

        $programacao = new Programacao();
        $return['evento'] = $programacao->siteEvento($id);
        $return['galeria'] = $programacao->siteEventoGaleria($id);
        // Eventos
        $programacao = new Programacao();
        $params = ['limit' => 6];
        $return['eventos'] = $programacao->siteEventos($params);

        $filtrosMesesDias = new Programacao();
        $return['filtrosMesesDias'] = $filtrosMesesDias->filtrosMesesDias();

        return view('evento')->withReturn($return);
    }
}
