<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Noticia;
use DateTime;

class NoticiaController extends Controller
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

        $noticia = new Noticia();
        $return['noticia'] = $noticia->siteNoticia($id);
        $arrayData = explode('-', explode(' ', $return['noticia']->created_at)[0]  );
        $arrayNomeMeses = [
            '01' => 'janeiro',
            '02' => 'fevereiro',
            '03' => 'março',
            '04' => 'abril',
            '05' => 'maio',
            '06' => 'junho',
            '07' => 'julho',
            '08' => 'agosto',
            '09' => 'setembro',
            '10' => 'outubro',
            '11' => 'novembro',
            '12' => 'dezembro'
        ];
        $return['noticia']->dataCompleta = $arrayData[2] . ' de ' . $arrayNomeMeses[$arrayData[1]] . ' de ' . $arrayData[0];
        $return['galeria'] = $noticia->siteNoticiaGaleria($id);

        return view('noticia')->withReturn($return);
    }
}
