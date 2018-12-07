<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;

class ContatoController extends Controller
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
        $return = [];
        $return['menus'] = 'contato';

        $categorias = new Categoria();
        $return['categorias'] = $categorias->all();

        return view('contato')->withReturn($return);
    }
}
