<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\QuemSomos;
use Classes\Helpers;
use Validator;
use DB;

class QuemSomosController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Quem Somos'];
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

        $quemSomos = new QuemSomos();
        $return['quemSomos'] = $quemSomos->listQuemSomos();
        if($erros)
        {
          return view('adm.quem-somos')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.quem-somos')->withReturn($return);
          } else {
              return redirect('/adm/quem-somos'); //Adicionado o redirect para limpar o post
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
                    'profession' => 'required|max:240',
                    'fileLogo.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileImageHeight.*' => 'nullable|image|dimensions:min_width=100,min_height=100'
                ];
                $messages = [
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais do que 240 caracteres.',
                    'profession.max' => 'Campo sub-title não pode ter mais do que 240 caracteres.',
                    'fileLogo.*.image' => 'Para o campo Imagem Width só é permitido arquivos do tipo imagem.',
                    'fileLogo.*.dimensions' => 'Para o Imagem Width a imagem não pode ser de dimensões inferiores que 100x100.',
                    'fileImageHeight.*.image' => 'Para o campo Imagem Height só é permitido arquivos do tipo imagem.',
                    'fileImageHeight.*.dimensions' => 'Para a Imagem Height a imagem não pode ser de dimensões inferiores que 100x100.',
                    'filesGaleria.*.image' => 'Para o campo Galeria só é permitido arquivos do tipo imagem.',
                    'filesGaleria.*.dimensions' => 'Para a Galeria as imagens não pode ser de dimensões inferiores que 100x100.'
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:240',
                    'profession' => 'required|max:240',
                    'fileLogo.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileImageHeight.*' => 'nullable|image|dimensions:min_width=100,min_height=100'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais do que 240 caracteres.',
                    'profession.required' => 'Campo profissão é obrigatório.',
                    'profession.max' => 'Campo profissão não pode ter mais do que 240 caracteres.',
                    'fileLogo.*.image' => 'Para o campo imagem horizontal só é permitido arquivos do tipo imagem.',
                    'fileLogo.*.dimensions' => 'Para a imagem horizontal a imagem não pode ser de dimensões inferiores que 100x100.',
                    'fileImageHeight.*.image' => 'Para o campo imagem vertical só é permitido arquivos do tipo imagem.',
                    'fileImageHeight.*.dimensions' => 'Para a imagem vertical a imagem não pode ser de dimensões inferiores que 100x100.'
                ];
                break;
            case 'delete':
                $rules = [
                    'idQuemSomos' => 'required'
                ];
                $messages = [
                    'idQuemSomos.required' => 'Nenhum registro informado!'
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
          $register = new QuemSomos();
          $register->curador = $request->input('curador') ? 'S' : 'N';
          $register->name = $request->input('name');
          $register->profession = $request->input('profession');
          $register->text = $request->input('text');

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
                  'path' => 'images/_QuemSomos/Width',
                  'pathThumb' => 'images/_QuemSomos/Width/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $register->image_width = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImageHeight
          // -------------------------------------------------------------------
          if (count($request->file('fileImageHeight')))
          {
              $params = [
                  'files' => $request->file('fileImageHeight'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_QuemSomos/Height',
                  'pathThumb' => 'images/_QuemSomos/Height/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $register->image_height = $idArray[0];
          }
          $register->save();

          $order = new QuemSomos();
          $orderEdit = $order->find($register->id);
          $orderEdit->order = $register->id;
          $orderEdit->save();

        return true;
    }



    private function delete(Request $request)
    {

        $id = $request->input('idQuemSomos');
        $registerDelete = new QuemSomos();
        $delete = $registerDelete->find($id);

        if ($delete->image_width)
        {
            $files = new File();
            $file = $files->find($delete->image_width);
            $nameFileFull = $file->namefilefull;
            $nameFileFullThumb = $file->namefilefullthumb;

            if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
            if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

            $file->delete();
        }
        if ($delete->image_height)
        {
            $files = new File();
            $file = $files->find($delete->image_height);
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
        $return = ['title' => 'Atualizar Quem Somos'];
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


        $quemSomos = new QuemSomos();
        $return['quemSomos'] = $quemSomos->find($id);

        // Retorna a banner prinpipal
        $imageWidth = new QuemSomos();
        $return['imageWidth'] = $imageWidth->returnaImageWidth($id);

        // Retorna a imagem prinpipal
        $imageHeight = new QuemSomos();
        $return['imageHeight'] = $imageHeight->returnaImageHeight($id);


        if(!count($return['quemSomos']) || !$id) {
            return redirect('/adm/quem-somos'); //Se não encontrar o registro volta para listagem
        }

        if($erros)
        {
          return view('adm.quem-somos-update')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.quem-somos-update')->withReturn($return);
          } else {
              return redirect('/adm/quem-somos-edit/'.$id); //Adicionado o redirect para limpar o post
          }
        }
    }

    private function order(Request $request)
    {
        $update = new QuemSomos();
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
            case 'ImagemWidth':
                $register = new QuemSomos();
                $delete = $register->find($request->input('id'));

                $files = new File();
                $file = $files->find($delete->image_width);
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();

                $delete->image_width = null;
                $delete->save();

                break;
            case 'ImagemHeight':
                $register = new QuemSomos();
                $delete = $register->find($request->input('id'));

                $files = new File();
                $file = $files->find($delete->image_height);
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();

                $delete->image_height = null;
                $delete->save();
                break;
        }

        return true;

    }



    private function edit(Request $request)
    {
          $quemSomos = new QuemSomos();
          $edit = $quemSomos->find($request->input('id'));
          $edit->curador = $request->input('curador') ? 'S' : 'N';
          $edit->name = $request->input('name');
          $edit->profession = $request->input('profession');
          $edit->text = $request->input('text');

          $helpers = new Helpers();

          // -------------------------------------------------------------------
          // FileImageWidth
          // -------------------------------------------------------------------
          if (count($request->file('fileImageWidth')))
          {
              if ($edit->image_width)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($edit->image_width);
                  $nameFileFull = $file->namefilefull;
                  $nameFileFullThumb = $file->namefilefullthumb;

                  if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                  if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                  $file->delete();
              }

              // Adiciona nova imagem
              $params = [
                  'files' => $request->file('fileImageWidth'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_QuemSomos/Width',
                  'pathThumb' => 'images/_QuemSomos/Width/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $edit->image_width = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImageHeight
          // -------------------------------------------------------------------
          if (count($request->file('fileImageHeight')))
          {
              if ($edit->image_height)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($edit->image_height);
                  $nameFileFull = $file->namefilefull;
                  $nameFileFullThumb = $file->namefilefullthumb;

                  if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                  if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                  $file->delete();
              }

              $params = [
                  'files' => $request->file('fileImageHeight'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_QuemSomos/Height',
                  'pathThumb' => 'images/_QuemSomos/Height/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $edit->image_height = $idArray[0];
          }
          $edit->save();


        return true;
    }

}
