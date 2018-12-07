<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Materia;
use App\Models\AdmHome;
use Validator;

class HomeController extends Controller
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
    public function index(Request $request)
    {
      $return = ['title' => 'HOME'];
      $erros = false;
      $firstCall = true;


      if ($request->isMethod('post'))
      {
          $firstCall = false;
          $validator = $this->validator($request);

          if (!$validator->fails())
          {
              switch ( $request->input('action') )
              {
                  case 'register':
                      $this->register($request);
                      break;
                  case 'edit':
                      $this->edit($request);
                      break;
                  case 'delete':
                      $this->delete($request);
                      break;
              }
          }
          else
          {
            $erros = true;
          }
      }


      return view('adm.home')->withReturn($return);

    }



    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = ['news' => 'required'];
                $messages = ['news.required' => 'Obrigatório selecionar uma notícia.'];
                break;
            case 'edit':
                $rules = ['id' => 'required'];
                $messages = ['id.required' => 'Nenhum registro informado'];
                break;
            case 'delete':
                $rules = ['id' => 'required'];
                $messages = ['id.required' => 'Nenhum registro informado!'];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function register(Request $request)
    {
        $register = new AdmHome();
        $id = 0;
        if ($register->max('id')) {
            $id = $register->max('id');
        }
        $id++;

        $register->materia = $request->input('news');
        $register->order = $id;
        $register->section = $request->input('section');

        $register->save();
        return true;
    }

    private function edit(Request $request)
    {
        $update = new AdmHome();
        $edit = $update->where('section', '=', $request->input('section'))->orderBy('order', 'asc')->get()->toArray();
        $id = $request->input('id');
        $orderNext = null;
        if( count($edit) > 1 )
        {
            for($i = 0; $i < count($edit); $i++)
            {
                if(isset($edit[$i+1]))
                {
                    if($edit[$i+1]['materia'] == $id)
                    {
                        $orderNext = $edit[$i+1]['order'];

                        $next = $update->find($edit[$i+1]['id']);
                        $next->order = $edit[$i]['order'];
                        $next->save();

                        $atual = $update->find($edit[$i]['id']);
                        $atual->order = $orderNext;
                        $atual->save();
                        return true;
                    }
                }
            }
        }

        return true;
    }

    private function delete(Request $request)
    {
        $delete = new AdmHome();
        $del = $delete->where('id', '=', $request->input('id'));
        $del->delete();

        return true;
    }

}
