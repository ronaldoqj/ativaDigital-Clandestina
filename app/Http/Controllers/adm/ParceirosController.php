<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Parceiro;
use Classes\Helpers;
use Validator;
use DB;

class ParceirosController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Parceiros'];
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
                    case 'order':
                        $this->order($request);
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

        $parceiros = new Parceiro();
        $return['parceiros'] = $parceiros->listParceiros();
        if($erros)
        {
          return view('adm.parceiros')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.parceiros')->withReturn($return);
          } else {
              return redirect('/adm/parceiros'); //Adicionado o redirect para limpar o post
          }
        }

    }

    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'name' => 'required|max:240',
                    'fileLogo.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileBackground.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'site' => 'nullable|max:240',
                    'facebook' => 'nullable|max:240',
                    'instagram' => 'nullable|max:240',
                    'twitter' => 'nullable|max:240',
                    'youtube' => 'nullable|max:240'
                ];
                $messages = [
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais do que 240 caracteres.',
                    'fileLogo.*.image' => 'Para o campo Logo só é permitido arquivos do tipo imagem.',
                    'fileLogo.*.dimensions' => 'Para o Logo a imagem não pode ser de dimensões inferiores que 100x100.',
                    'fileBackground.*.image' => 'Para o campo Background só é permitido arquivos do tipo imagem.',
                    'fileBackground.*.dimensions' => 'Para a Background a imagem não pode ser de dimensões inferiores que 100x100.',
                    'site.max' => 'Campo site não pode ter mais do que 240 caracteres.',
                    'facebook.max' => 'Campo facebook não pode ter mais do que 240 caracteres.',
                    'instagram.max' => 'Campo instagram não pode ter mais do que 240 caracteres.',
                    'twitter.max' => 'Campo twitter não pode ter mais do que 240 caracteres.',
                    'youtube.max' => 'Campo youtube não pode ter mais do que 240 caracteres.'
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:240',
                    'fileLogo.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileBackground.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'site' => 'nullable|max:240',
                    'facebook' => 'nullable|max:240',
                    'instagram' => 'nullable|max:240',
                    'twitter' => 'nullable|max:240',
                    'youtube' => 'nullable|max:240'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais do que 240 caracteres.',
                    'fileLogo.*.image' => 'Para o campo imagem logo só é permitido arquivos do tipo imagem.',
                    'fileLogo.*.dimensions' => 'Para a imagem logo a imagem não pode ser de dimensões inferiores que 100x100.',
                    'fileBackground.*.image' => 'Para o campo imagem background só é permitido arquivos do tipo imagem.',
                    'fileBackground.*.dimensions' => 'Para o campo imagem background não pode ser de dimensões inferiores que 100x100.',
                    'site.max' => 'Campo site não pode ter mais do que 240 caracteres.',
                    'facebook.max' => 'Campo facebook não pode ter mais do que 240 caracteres.',
                    'instagram.max' => 'Campo instagram não pode ter mais do que 240 caracteres.',
                    'twitter.max' => 'Campo twitter não pode ter mais do que 240 caracteres.',
                    'youtube.max' => 'Campo youtube não pode ter mais do que 240 caracteres.'
                ];
                break;
            case 'delete':
                $rules = [
                    'idParceiro' => 'required'
                ];
                $messages = [
                    'idParceiro.required' => 'Nenhum registro informado!'
                ];
                break;
            case 'delete-image':
                $rules = [
                    'id' => 'required',
                    'campo' => 'required',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'campo.required' => 'Não foi possivel indentificar o campo a ser excluído!',
                ];
                break;
            case 'order':
                $rules = [
                  'id' => 'required',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function register(Request $request)
    {
          $register = new Parceiro();
          $register->name = $request->input('name');
          $register->text = $request->input('text');
          $register->site = $request->input('site');
          $register->facebook = $request->input('facebook');
          $register->twitter = $request->input('twitter');
          $register->instagram = $request->input('instagram');
          $register->youtube = $request->input('youtube');

          $helpers = new Helpers();


          // -------------------------------------------------------------------
          // FileImageWidth
          // -------------------------------------------------------------------
          if (count($request->file('fileLogo')))
          {
              $params = [
                  'files' => $request->file('fileLogo'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_Parceiros/Logo',
                  'pathThumb' => 'images/_Parceiros/Logo/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $register->image_logo = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImageHeight
          // -------------------------------------------------------------------
          if (count($request->file('fileBackground')))
          {
              $params = [
                  'files' => $request->file('fileBackground'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_Parceiros/Background',
                  'pathThumb' => 'images/_Parceiros/Background/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $register->image_background = $idArray[0];
          }
          $register->save();

          $order = new Parceiro();
          $orderEdit = $order->find($register->id);
          $orderEdit->order = $register->id;
          $orderEdit->save();

        return true;
    }



    private function delete(Request $request)
    {

        $id = $request->input('idParceiro');
        $registerDelete = new Parceiro();
        $delete = $registerDelete->find($id);

        if ($delete->image_logo)
        {
            $files = new File();
            $file = $files->find($delete->image_logo);
            $nameFileFull = $file->namefilefull;
            $nameFileFullThumb = $file->namefilefullthumb;

            if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
            if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

            $file->delete();
        }
        if ($delete->image_background)
        {
            $files = new File();
            $file = $files->find($delete->image_background);
            $nameFileFull = $file->namefilefull;
            $nameFileFullThumb = $file->namefilefullthumb;

            if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
            if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

            $file->delete();
        }

        // Deleta a Galeria reaproveitando a função delete galerias feita no editar abaixo

        $delete->delete();
        return true;
    }







    // ================================================================================
    // ============================= Edição das casas =================================
    // ================================================================================


    public function update(Request $request, $id = null)
    {
        $return = ['title' => 'Atualizar Parceiros'];
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
                    case 'delete-image':
                        $this->deleteImage($request);
                        break;
                }
            }
            else
            {
              $erros = true;
            }
        }

        $parceiros = new Parceiro();
        $return['parceiros'] = $parceiros->find($id);

        // Retorna a banner prinpipal
        $imageLogo = new Parceiro();
        $return['image_logo'] = $imageLogo->returnaImageLogo($id);

        // Retorna a imagem prinpipal
        $imageBackground = new Parceiro();
        $return['image_background'] = $imageBackground->returnaImageBackground($id);


        if(!count($return['parceiros']) || !$id) {
            return redirect('/adm/parceiros'); //Se não encontrar o registro volta para listagem
        }

        if($erros)
        {
          return view('adm.parceiros-update')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.parceiros-update')->withReturn($return);
          } else {
              return redirect('/adm/parceiros-edit/'.$id); //Adicionado o redirect para limpar o post
          }
        }
    }

    private function order(Request $request)
    {
        $update = new Parceiro();
        $edit = $update->all()->sortByDesc('order')->toArray();
        $orderNext = null;

        if( count($edit) > 1 )
        {
            for($i = 0; $i < count($edit); $i++)
            {
                if(isset($edit[$i+1]))
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

        return true;
    }


    private function deleteImage(Request $request)
    {

        switch ( $request->input('campo') )
        {
            case 'ImagemLogo':
                $register = new Parceiro();
                $delete = $register->find($request->input('id'));

                $files = new File();
                $file = $files->find($delete->image_logo);
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();

                $delete->image_logo = null;
                $delete->save();

                break;
            case 'ImagemBackground':
                $register = new Parceiro();
                $delete = $register->find($request->input('id'));

                $files = new File();
                $file = $files->find($delete->image_background);
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();

                $delete->image_background = null;
                $delete->save();
                break;
        }

        return true;

    }



    private function edit(Request $request)
    {
          $parceiros = new Parceiro();
          $edit = $parceiros->find($request->input('id'));
          $edit->name = $request->input('name');
          $edit->text = $request->input('text');
          $edit->site = $request->input('site');
          $edit->facebook = $request->input('facebook');
          $edit->twitter = $request->input('twitter');
          $edit->instagram = $request->input('instagram');
          $edit->youtube = $request->input('youtube');

          $helpers = new Helpers();

          // -------------------------------------------------------------------
          // FileImageWidth
          // -------------------------------------------------------------------
          if (count($request->file('fileLogo')))
          {
              if ($edit->image_logo)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($edit->image_logo);
                  $nameFileFull = $file->namefilefull;
                  $nameFileFullThumb = $file->namefilefullthumb;

                  if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                  if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                  $file->delete();
              }

              // Adiciona nova imagem
              $params = [
                  'files' => $request->file('fileLogo'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_Parceiros/Logo',
                  'pathThumb' => 'images/_Parceiros/Logo/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $edit->image_logo = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImageHeight
          // -------------------------------------------------------------------
          if (count($request->file('fileBackground')))
          {
              if ($edit->image_background)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($edit->image_background);
                  $nameFileFull = $file->namefilefull;
                  $nameFileFullThumb = $file->namefilefullthumb;

                  if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                  if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                  $file->delete();
              }

              $params = [
                  'files' => $request->file('fileBackground'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_Parceiros/Background',
                  'pathThumb' => 'images/_Parceiros/Background/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $edit->image_background = $idArray[0];
          }
          $edit->save();


        return true;
    }

}
