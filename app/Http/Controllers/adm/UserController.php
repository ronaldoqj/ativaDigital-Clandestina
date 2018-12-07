<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      $return = ['title' => 'Usuário'];
      $erros = false;
      $firstCall = true;

        if($request->isMethod('post'))
        {
            $firstCall = false;
            $validator = $this->validator($request);

            if (!$validator->fails())
            {
                switch ( $request->input('action') )
                {
                    case 'edit':
                        $this->edit($request);
                }
            }
            else
            {
              $erros = true;
            }
        }

        $User = new User();
        $user = $User->where('email', '!=', 'master@adm.com')->get();
        $return['return'] = $user;

        if($erros)
        {
          return view('adm.user')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.user')->withReturn($return);
          } else {
              return redirect('/adm/usuario'); //Adicionado o redirect para limpar o post
          }
        }
    }


    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:190',
                    'email' => 'required|max:190',
                    'password' => 'max:190'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'name.required' => 'Campo nome é obrigatório.',
                    'email.required' => 'Campo email é obrigatório.',
                    'name.max' => 'Campo nome é não pode ter mais que 190 caracteres.',
                    'email.max' => 'Campo E-Mail é não pode ter mais que 190 caracteres.',
                    'password.max' => 'Campo senha é não pode ter mais que 190 caracteres.'
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function edit($request)
    {
        $user = new User();
        $edit = $user->find(Auth::user()->id);
        $edit->name = $request->input('name');
        $edit->email = $request->input('email');
        if ($request->input('password')) {
            $edit->password = bcrypt($request->input('password'));
        }

        $edit->save();
        return true;
    }

}
