<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesquisa;

class PesquisaController extends Controller
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
    public function index(Request $request)
    {
        $return = [ 'pesquisa'  => '',
                    'eventos'   => [],
                    'conteudos' => [],
                    'lugares'   => [] ];

        if ($request->isMethod('post'))
        {
            $inputPesquisa = $request->input('pesquisa');
            $pesquisa = new Pesquisa();
            $return = $pesquisa->pesquisa($inputPesquisa);
        }

        return view('pesquisa')->withReturn($return);
    }
}
