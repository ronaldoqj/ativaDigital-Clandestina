<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaisController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = 'editar')
    {

        if ($request->isMethod('post'))
        {
            if ($id == 'cadastrar')
            {
                if( $this->validatorInputs($request) )
                {
                    
                }
            }
            else
            {
                if( $this->validatorInputs($request) )
                {
                    
                }
            }
        }

        return view('adm.locais')->withAction($id);
    }

    private function validatorInputs($request) {
        $validator = true;
        
        $inputArray = ['nameLocal', 'adress', 'price', 'function-day'];
        $text = '';
        
        for ($i = 0; $i < sizeof($inputArray); $i++)
        {
            if ( !$request->input($inputArray[$i]) ) {
                $validator = false;
            }
        }
        
        //dd($request->file('file'));
        //dd($validator);
        
        //$request->input('id');
        
        /*
        nameLocal
        adress
        price
        file
        function-day
        ranking
        editor1
        */
        return $validator;
    }

    private function register() {
        
        return true;
    }
    
    private function edit() {
        
        return true;
    }
}