<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\QuemSomos;

class QuemSomosController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $quemSomos = new QuemSomos();
        $return['quemSomos'] = $quemSomos->Site_listQuemSomos();
        $return['curadores'] = $quemSomos->Site_listCuradores();
        // dd($return);
        return view('quem-somos')->withReturn($return);
    }
}
