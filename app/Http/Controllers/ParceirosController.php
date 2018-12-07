<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Parceiro;

class ParceirosController extends Controller
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
        $return['menus'] = 'parceiros';

        $parceiros = new Parceiro();
        $return['parceiros'] = $parceiros->listParceiros();

        return view('parceiros')->withReturn($return);
    }
}
