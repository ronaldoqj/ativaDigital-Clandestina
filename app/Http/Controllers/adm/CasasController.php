<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Casa;
use App\Models\File;
use App\Models\FilesGaleria;
use App\Models\CasasHasCategoria;
use App\Models\GaleriaHasFileGaleria;
use App\Models\Programacao;
use App\Models\ProgramacaoHasLocal;
use Classes\Helpers;
use Validator;
use DB;

class CasasController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Casas'];
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

        $categoria = new Categoria();
        $return['categorias'] = $categoria->all();

        $casa = new Casa();
        $return['casas'] = $casa->listCasas();
        if($erros)
        {
          return view('adm.casas')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.casas')->withReturn($return);
          } else {
              return redirect('/adm/casas'); //Adicionado o redirect para limpar o post
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
                    'sub_title' => 'nullable|max:240',
                    'telefone' => 'nullable|max:20',
                    'celular' => 'nullable|max:20',
                    'cep' => 'nullable|max:9',
                    'endereco' => 'nullable|max:240',
                    'cidade' => 'nullable|max:240',
                    'numero' => 'nullable|max:10',
                    'responsavel' => 'nullable|max:240',
                    'telefoneResponsavel' => 'nullable|max:20',
                    'celularResponsavel' => 'nullable|max:20',
                    'title_banner' => 'nullable|max:240',
                    'legendaBannerPrincipal' => 'nullable|max:240',
                    'legendaImagemPrincipal' => 'nullable|max:240',
                    'fileBannerPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileImagemPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'filesGaleria.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'namedefault' => 'nullable|max:140',
                    'site' => 'nullable|max:240',
                    'facebook' => 'nullable|max:240',
                    'twiiter' => 'nullable|max:240',
                    'instagram' => 'nullable|max:240',
                    'whatsapp' => 'nullable|max:240',
                    'youtube' => 'nullable|max:240',
                ];
                $messages = [
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais do que 240 caracteres.',
                    'sub_title.max' => 'Campo sub-title não pode ter mais do que 240 caracteres.',
                    'telefone.max' => 'Campo telefone não pode ter mais do que 20 caracteres.',
                    'celular.max' => 'Campo celular não pode ter mais do que 20 caracteres.',
                    'cep.max' => 'Campo CEP não pode ter mais do que 9 caracteres.',
                    'endereco.max' => 'Campo endereço não pode ter mais do que 240 caracteres.',
                    'cidade.max' => 'Nome cidade não pode ter mais do que 240 caracteres.',
                    'numero.max' => 'Nome número não pode ter mais do que 10 caracteres.',
                    'responsavel.max' => 'Nome responável não pode ter mais do que 240 caracteres.',
                    'telefoneResponsavel.max' => 'Campo telefone do responsável não pode ter mais do que 20 caracteres.',
                    'celularResponsavel.max' => 'Campo celular do responsável não pode ter mais do que 20 caracteres.',
                    'title_banner.max' => 'Campo título banner não pode ter mais do que 240 caracteres.',
                    'legendaBannerPrincipal.max' => 'Campo legenda do banner principal não pode ter mais do que 240 caracteres.',
                    'legendaImagemPrincipal.max' => 'Campo legenda da imagem principal não pode ter mais do que 240 caracteres.',
                    'fileBannerPrincipal.*.image' => 'Para o campo Banner Principal só é permitido arquivos do tipo imagem.',
                    'fileBannerPrincipal.*.dimensions' => 'Para o Banner Principal a imagem não pode ser de dimensões inferiores que 100x100.',
                    'fileImagemPrincipal.*.image' => 'Para o campo Imagem Principal só é permitido arquivos do tipo imagem.',
                    'fileImagemPrincipal.*.dimensions' => 'Para a Imagem Principal a imagem não pode ser de dimensões inferiores que 100x100.',
                    'filesGaleria.*.image' => 'Para o campo Galeria só é permitido arquivos do tipo imagem.',
                    'filesGaleria.*.dimensions' => 'Para a Galeria as imagens não pode ser de dimensões inferiores que 100x100.',
                    'namedefault.max' => 'Campo nome padrão não pode ter mais do que 140 caracteres.',
                    'site.max' => 'Campo site não pode ter mais do que 240 caracteres.',
                    'facebook.max' => 'Campo Facebook não pode ter mais do que 240 caracteres.',
                    'twiiter.max' => 'Campo Twiiter não pode ter mais do que 240 caracteres.',
                    'instagram.max' => 'Campo Instagram não pode ter mais do que 240 caracteres.',
                    'whatsapp.max' => 'Campo Whatsapp não pode ter mais do que 240 caracteres.',
                    'youtube.max' => 'Campo Youtube não pode ter mais do que 240 caracteres.',
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:240',
                    'sub_title' => 'nullable|max:240',
                    'telefone' => 'nullable|max:20',
                    'celular' => 'nullable|max:20',
                    'cep' => 'nullable|max:9',
                    'endereco' => 'nullable|max:240',
                    'cidade' => 'nullable|max:240',
                    'numero' => 'nullable|max:10',
                    'responsavel' => 'nullable|max:240',
                    'telefoneResponsavel' => 'nullable|max:20',
                    'celularResponsavel' => 'nullable|max:20',
                    'title_banner' => 'nullable|max:240',
                    'legendaBannerPrincipal' => 'nullable|max:240',
                    'legendaImagemPrincipal' => 'nullable|max:240',
                    'fileBannerPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileImagemPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'filesGaleria.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'namedefault' => 'nullable|max:140',
                    'site' => 'nullable|max:240',
                    'facebook' => 'nullable|max:240',
                    'twiiter' => 'nullable|max:240',
                    'instagram' => 'nullable|max:240',
                    'whatsapp' => 'nullable|max:240',
                    'youtube' => 'nullable|max:240',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais do que 240 caracteres.',
                    'sub_title.max' => 'Campo sub-title não pode ter mais do que 240 caracteres.',
                    'telefone.max' => 'Campo telefone não pode ter mais do que 20 caracteres.',
                    'celular.max' => 'Campo celular não pode ter mais do que 20 caracteres.',
                    'cep.max' => 'Campo CEP não pode ter mais do que 9 caracteres.',
                    'endereco.max' => 'Campo endereço não pode ter mais do que 240 caracteres.',
                    'cidade.max' => 'Nome cidade não pode ter mais do que 240 caracteres.',
                    'numero.max' => 'Nome número não pode ter mais do que 10 caracteres.',
                    'responsavel.max' => 'Nome responável não pode ter mais do que 240 caracteres.',
                    'telefoneResponsavel.max' => 'Campo telefone do responsável não pode ter mais do que 20 caracteres.',
                    'celularResponsavel.max' => 'Campo celular do responsável não pode ter mais do que 20 caracteres.',
                    'title_banner.max' => 'Campo título banner não pode ter mais do que 240 caracteres.',
                    'legendaBannerPrincipal.max' => 'Campo legenda do banner principal não pode ter mais do que 240 caracteres.',
                    'legendaImagemPrincipal.max' => 'Campo legenda da imagem principal não pode ter mais do que 240 caracteres.',
                    'fileBannerPrincipal.*.image' => 'Para o campo Banner Principal só é permitido arquivos do tipo imagem.',
                    'fileBannerPrincipal.*.dimensions' => 'Para o Banner Principal a imagem não pode ser de dimensões inferiores que 100x100.',
                    'fileImagemPrincipal.*.image' => 'Para o campo Imagem Principal só é permitido arquivos do tipo imagem.',
                    'fileImagemPrincipal.*.dimensions' => 'Para a Imagem Principal a imagem não pode ser de dimensões inferiores que 100x100.',
                    'filesGaleria.*.image' => 'Para o campo Galeria só é permitido arquivos do tipo imagem.',
                    'filesGaleria.*.dimensions' => 'Para a Galeria as imagens não pode ser de dimensões inferiores que 100x100.',
                    'namedefault.max' => 'Campo nome padrão não pode ter mais do que 140 caracteres.',
                    'facebook.max' => 'Campo Facebook não pode ter mais do que 240 caracteres.',
                    'twiiter.max' => 'Campo Twiiter não pode ter mais do que 240 caracteres.',
                    'instagram.max' => 'Campo Instagram não pode ter mais do que 240 caracteres.',
                    'whatsapp.max' => 'Campo Whatsapp não pode ter mais do que 240 caracteres.',
                    'youtube.max' => 'Campo Youtube não pode ter mais do que 240 caracteres.',
                ];
                break;
            case 'delete':
                $rules = [
                    'idCasa' => 'required'
                ];
                $messages = [
                    'idCasa.required' => 'Nenhum registro informado!'
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
            case 'order-image-galeria':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
                break;
            case 'edit-image-galeria':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:140',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'name.required' => 'Campo nome da imagem é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                ];
                break;
            case 'delete-image-galeria':
                $rules = [
                    'id' => 'required',
                    'idCasa' => 'required',
                ];
                $messages = [
                    'id.required' => 'Não foi possível identificar o registro!',
                    'idCasa.required' => 'Não foi possível identificar o arquivo a ser excluído!',
                ];
                break;
            case 'delete-galeria':
                $rules = [
                    'idCasa' => 'required',
                ];
                $messages = [
                    'idCasa.required' => 'Não foi possível identificar a galeria a ser excluída!',
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if($request->input('action') == 'delete')
        {
            $validator = $this->validaDelete($request, $validator);
        }
        return $validator;
    }


    private function register(Request $request)
    {
          $casa = new Casa();
          $casa->name = $request->input('name');
          $casa->sub_title = $request->input('sub_title');
          $casa->diasHorarios = $request->input('diasHorarios');
          $casa->diasHorarios2 = $request->input('diasHorarios2');
          $casa->telefone = $request->input('telefone');
          $casa->celular = $request->input('celular');
          $casa->cep = $request->input('cep');
          $casa->endereco = $request->input('endereco');
          $casa->cidade = $request->input('cidade');
          $casa->numero = $request->input('numero');
          $casa->UF = $request->input('UF');
          $casa->localizacao = $request->input('localizacao');
          $casa->responsavel = $request->input('responsavel');
          $casa->telefone_responsavel = $request->input('telefoneResponsavel');
          $casa->celular_responsavel = $request->input('celularResponsavel');
          $casa->title_banner = $request->input('title_banner');
          $casa->legenda_banner = $request->input('legendaBanner');
          $casa->legenda_imagem = $request->input('legendaImagem');
          $casa->site = $request->input('site');
          $casa->facebook = $request->input('facebook');
          $casa->twitter = $request->input('twitter');
          $casa->instagram = $request->input('instagram');
          $casa->whatsapp = $request->input('whatsapp');
          $casa->youtube = $request->input('youtube');

          $helpers = new Helpers();

          // -------------------------------------------------------------------
          // FileBannerPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileBannerPrincipal')))
          {
              $params = [
                  'files' => $request->file('fileBannerPrincipal'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_BannerPrincipal',
                  'pathThumb' => 'images/_BannerPrincipal/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $casa->banner_principal = $idArray[0];
          }

          // -------------------------------------------------------------------
          // FileImagemPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileImagemPrincipal')))
          {
              $params = [
                  'files' => $request->file('fileImagemPrincipal'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_ImagemPrincipal',
                  'pathThumb' => 'images/_ImagemPrincipal/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $casa->imagem_principal = $idArray[0];
          }
          $casa->save();

          // -------------------------------------------------------------------
          // Categorias
          // -------------------------------------------------------------------
          $categoriasArray = [];
          if ($request->input('categorias')) { $categoriasArray = explode(",", $request->input('categorias')); }

          if (count($categoriasArray))
          {
              foreach ($categoriasArray as $item)
              {
                  $casasHasCategoria = new CasasHasCategoria();
                  $casasHasCategoria->id_casa = $casa->id;
                  $casasHasCategoria->id_categoria = $item;
                  $casasHasCategoria->save();
              }
          }

          // -------------------------------------------------------------------
          // Galerias
          // -------------------------------------------------------------------
          if (count($request->file('filesGaleria')))
          {
              $params = [
                  'files' => $request->file('filesGaleria'),
                  'model' => 'FilesGaleria',
                  'thumb' => true,
                  'path' => 'images/_Galeria',
                  'pathThumb' => 'images/_Galeria/_Thumbs',
                  'namedefault' => $request->input('namedefault')
              ];
              $idArray = $helpers->uploadImages( $params );
              foreach ($idArray as $item)
              {
                  $galeriaHasImagem = new GaleriaHasFileGaleria();
                  $idOrder = 0;

                  if ($galeriaHasImagem->where('id_casa', '!=', '')->max('order')) {
                      $idOrder = $galeriaHasImagem->where('id_casa', '!=', '')->max('order');
                  }
                  $idOrder++;

                  $galeriaHasImagem->id_casa = $casa->id;
                  $galeriaHasImagem->id_file = $item;
                  $galeriaHasImagem->order = $idOrder;
                  $galeriaHasImagem->save();
              }
          }

        return true;
    }


    private function validaDelete (Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';
        $Casas = new Casa();
        $casas = $Casas->find($request->input('idCasa'));

        if (!$casas)
        {
            $erro = true;
            $Mensagem = 'Não foi encontrado nenhuma casa no Banco de Imagens';
            $this->msgErros = $Mensagem;
        }
        else
        {
            $Verifica = new ProgramacaoHasLocal();
            $verifica = $Verifica->all()->where('id_local', $casas->id);
            $Mensagem = '';

            if( count($verifica) )
            {
                $erro = true;
                $Mensagem .= 'A matéria está sendo utilizada nas seguintes programações:';
                $Mensagem .= '<ul>';

                foreach($verifica as $item) {
                    $Programacao = new Programacao();
                    $programacao = $Programacao->find($item->id_programacao);
                    if ($programacao) {
                        $Mensagem .= '<li>'. $programacao->name .'.</li>';
                    }
                }

                $Mensagem .= '</ul>';
                $this->msgErros .= $Mensagem;
            }
        }

        if($erro)
        {
            $validator->after(function ($validator) {
                $validator->errors()->add('field', $this->msgErros);
            });
        }

        return $validator;
    }


    private function delete(Request $request)
    {
        $id = $request->input('idCasa');
        $casasHasCategoria = new CasasHasCategoria();
        $casasCategorias = $casasHasCategoria->where('id_casa', '=', $id);
        $casasCategorias->delete();
        $registerDelete = new Casa();
        $delete = $registerDelete->find($id);

        if ($delete->banner_principal)
        {
            $files = new File();
            $file = $files->find($delete->banner_principal);
            if ($file)
            {
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();
            }
        }

        if ($delete->imagem_principal)
        {
            $files = new File();
            $file = $files->find($delete->imagem_principal);

            if ($file)
            {
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();
            }
        }

        // Deleta a Galeria reaproveitando a função delete galerias feita no editar abaixo
        $this->deleteGaleria($request);

        $delete->delete();
        return true;
    }


    // ================================================================================
    // ============================= Edição das casas =================================
    // ================================================================================

    public function update(Request $request, $id = null)
    {
        $return = ['title' => 'Atualizar Casa'];
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
                    case 'order-image-galeria':
                        $this->orderImage($request);
                        break;
                    case 'edit-image-galeria':
                        $this->editImageGaleria($request);
                        break;
                    case 'delete-image-galeria':
                        $this->deleteImageGaleria($request);
                        break;
                    case 'delete-galeria':
                        $this->deleteGaleria($request);
                        break;
                }
            }
            else
            {
              $erros = true;
            }
        }

        $categoria = new Categoria();
        $return['categorias'] = $categoria->all();

        $casa = new Casa();
        $return['casa'] = $casa->find($id);

        // Retorna as categorias cadastradas
        $casaCategorias = new CasasHasCategoria();
        $return['casaCategorias'] = $casaCategorias->where('id_casa', '=', $id)->get();

        // Retorna a banner prinpipal
        $bannerPrincipal = new Casa();
        $return['bannerPrincipal'] = $bannerPrincipal->returnaBannerPrincipal($id);

        // Retorna a imagem prinpipal
        $imagemPrincipal = new Casa();
        $return['imagemPrincipal'] = $bannerPrincipal->returnaImagemPrincipal($id);

        // Retorna a galeria
        $galeria = new GaleriaHasFileGaleria();
        $return['galeria'] = $galeria->listGaleriaADM($id);

        if(!count($return['casa']) || !$id) {
            return redirect('/adm/casas'); //Se não encontrar o registro volta para listagem
        }

        if($erros)
        {
          return view('adm.casas-update')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.casas-update')->withReturn($return);
          } else {
              return redirect('/adm/casas-edit/'.$id); //Adicionado o redirect para limpar o post
          }
        }
    }


    private function orderImage(Request $request)
    {
      $trueFalse = true;

      $update = new GaleriaHasFileGaleria();
      $edit = $update->where('id_casa', '=', $request->input('idCasa'))->orderBy('order')->get()->toArray();
      $id = $request->input('id');
      $orderNext = null;
      if( count($edit) > 1 )
      {
          for($i = 0; $i < count($edit); $i++)
          {
              if(isset($edit[$i+1]))
              {
                  if($edit[$i+1]['id'] == $id)
                  {
                      $orderNext = $edit[$i+1]['order'];

                      $next = $update->find($edit[$i+1]['id']);
                      $next->order = $edit[$i]['order'];
                      $next->save();

                      $atual = $update->find($edit[$i]['id']);
                      $atual->order = $orderNext;
                      $atual->save();
                  }
              }
          }
      }

      return $trueFalse;
    }

    private function editImageGaleria(Request $request)
    {
        $update = new FilesGaleria();
        $edit = $update->find($request->input('id'));
        $edit->name = $request->input('name');

        $edit->save();

        return true;
    }

    private function deleteGaleria(Request $request)
    {
        $idCasa = $request->input('idCasa');

        $hasImagem = new GaleriaHasFileGaleria();
        $deleteHasImagem = $hasImagem->where('id_casa', $idCasa);

        if ($deleteHasImagem->get()->toArray())
        {
            $arrayIds = [];
            foreach ($deleteHasImagem->get() as $idsImages)
            {
                $arrayIds[] = $idsImages->id_file;
            }

            $file = new FilesGaleria();
            $deleteFiles = $file->wherein('id', $arrayIds);

            foreach ($deleteFiles->get() as $itemFile)
            {
                if ( file_exists($itemFile->namefilefullthumb) )
                {
                    unlink($itemFile->namefilefullthumb);
                    unlink($itemFile->namefilefull);
                }
            }

            $deleteFiles->delete();
            $deleteHasImagem->delete();
        }

        return true;
    }

    private function deleteImageGaleria(Request $request)
    {
        $id = $request->input('id');
        $idCasa = $request->input('idCasa');

        $hasImagem = new GaleriaHasFileGaleria();
        $deleteHasImagem = $hasImagem->where('id_casa', $idCasa)->where('id', $id)->first();

        if ($deleteHasImagem)
        {
            $file = new FilesGaleria();
            $deleteFile = $file->find($id);

            if ( file_exists($deleteFile->namefilefullthumb) ) {
                $deleteFile->delete();
                $deleteHasImagem->delete();
                unlink($deleteFile->namefilefullthumb);
                unlink($deleteFile->namefilefull);
            }
        }

        return true;
    }

    private function deleteImage(Request $request)
    {
        switch ( $request->input('campo') )
        {
            case 'BannerPrincipal':
                $register = new Casa();
                $delete = $register->find($request->input('id'));

                $files = new File();
                $file = $files->find($delete->banner_principal);
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();

                $delete->banner_principal = null;
                $delete->save();

                break;
            case 'ImagemPrincipal':
                $register = new Casa();
                $delete = $register->find($request->input('id'));

                $files = new File();
                $file = $files->find($delete->imagem_principal);
                $nameFileFull = $file->namefilefull;
                $nameFileFullThumb = $file->namefilefullthumb;

                if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                $file->delete();

                $delete->imagem_principal = null;
                $delete->save();
                break;
        }

        return true;
    }


    private function edit(Request $request)
    {
          $casas = new Casa();
          $casa = $casas->find($request->input('id'));
          $casa->name = $request->input('name');
          $casa->sub_title = $request->input('sub_title');
          $casa->diasHorarios = $request->input('diasHorarios');
          $casa->diasHorarios2 = $request->input('diasHorarios2');
          $casa->telefone = $request->input('telefone');
          $casa->celular = $request->input('celular');
          $casa->cep = $request->input('cep');
          $casa->endereco = $request->input('endereco');
          $casa->cidade = $request->input('cidade');
          $casa->numero = $request->input('numero');
          $casa->UF = $request->input('UF');
          $casa->localizacao = $request->input('localizacao');
          $casa->responsavel = $request->input('responsavel');
          $casa->telefone_responsavel = $request->input('telefoneResponsavel');
          $casa->celular_responsavel = $request->input('celularResponsavel');
          $casa->title_banner = $request->input('title_banner');
          $casa->legenda_banner = $request->input('legendaBanner');
          $casa->legenda_imagem = $request->input('legendaImagem');
          $casa->site = $request->input('site');
          $casa->facebook = $request->input('facebook');
          $casa->twitter = $request->input('twitter');
          $casa->instagram = $request->input('instagram');
          $casa->whatsapp = $request->input('whatsapp');
          $casa->youtube = $request->input('youtube');

          $helpers = new Helpers();

          // -------------------------------------------------------------------
          // FileBannerPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileBannerPrincipal')))
          {
              if ($casa->banner_principal)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($casa->banner_principal);
                  $nameFileFull = $file->namefilefull;
                  $nameFileFullThumb = $file->namefilefullthumb;

                  if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                  if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                  $file->delete();
              }

              // Adiciona nova imagem
              $params = [
                'files' => $request->file('fileBannerPrincipal'),
                'model' => 'File',
                'thumb' => true,
                'path' => 'images/_BannerPrincipal',
                'pathThumb' => 'images/_BannerPrincipal/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $casa->banner_principal = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImagemPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileImagemPrincipal')))
          {
              if ($casa->imagem_principal)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($casa->imagem_principal);
                  $nameFileFull = $file->namefilefull;
                  $nameFileFullThumb = $file->namefilefullthumb;

                  if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
                  if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

                  $file->delete();
              }

              $params = [
                  'files' => $request->file('fileImagemPrincipal'),
                  'model' => 'File',
                  'thumb' => true,
                  'path' => 'images/_ImagemPrincipal',
                  'pathThumb' => 'images/_ImagemPrincipal/_Thumbs'
              ];
              $idArray = $helpers->uploadImages( $params );
              $casa->imagem_principal = $idArray[0];
          }
          $casa->save();

          // -------------------------------------------------------------------
          // Categorias
          // -------------------------------------------------------------------
          $DCHC = new CasasHasCategoria();
          $DeleteDCHC = $DCHC->where('id_casa', $casa->id);
          $DeleteDCHC->delete();

          $categoriasArray = [];
          if ($request->input('categorias')) { $categoriasArray = explode(",", $request->input('categorias')); }

          if (count($categoriasArray))
          {
              foreach ($categoriasArray as $item)
              {
                  $casasHasCategoria = new CasasHasCategoria();
                  $casasHasCategoria->id_casa = $casa->id;
                  $casasHasCategoria->id_categoria = $item;
                  $casasHasCategoria->save();
              }
          }

          // -------------------------------------------------------------------
          // Galerias
          // -------------------------------------------------------------------
          if (count($request->file('filesGaleria')))
          {
              $params = [
                  'files' => $request->file('filesGaleria'),
                  'model' => 'FilesGaleria',
                  'thumb' => true,
                  'path' => 'images/_Galeria',
                  'pathThumb' => 'images/_Galeria/_Thumbs',
                  'namedefault' => $request->input('namedefault')
              ];
              $idArray = $helpers->uploadImages( $params );
              foreach ($idArray as $item)
              {
                  $galeriaHasImagem = new GaleriaHasFileGaleria();
                  $idOrder = 0;

                  if ($galeriaHasImagem->where('id_casa', '!=', '')->max('order')) {
                      $idOrder = $galeriaHasImagem->where('id_casa', '!=', '')->max('order');
                  }
                  $idOrder++;

                  $galeriaHasImagem->id_casa = $casa->id;
                  $galeriaHasImagem->id_file = $item;
                  $galeriaHasImagem->order = $idOrder;
                  $galeriaHasImagem->save();
              }
          }

        return true;
    }

}
