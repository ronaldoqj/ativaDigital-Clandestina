<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Programacao;
use App\Models\Casa;
use App\Models\File;
use App\Models\FilesGaleria;
use App\Models\ProgramacaoHasCategoria;
use App\Models\ProgramacaoHasLocal;
use App\Models\GaleriaHasFileGaleria;
use Classes\Helpers;
use Validator;
use DateTime;
use DB;

class ProgramacoesController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Programações'];
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

        $programacao = new Programacao();
        $return['programacoes'] = $programacao->listProgramacoes();

        $casa = new Casa();
        $return['casas'] = $casa->listCasas();

        if($erros)
        {
          return view('adm.programacoes')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.programacoes')->withReturn($return);
          } else {
              return redirect('/adm/programacoes'); //Adicionado o redirect para limpar o post
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
                    'linkIngressos' => 'nullable|max:240',
                    'title_banner' => 'nullable|max:240',
                    'legendaBannerPrincipal' => 'nullable|max:240',
                    'legendaImagemPrincipal' => 'nullable|max:240',
                    'fileBannerPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileImagemPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'filesGaleria.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'namedefault' => 'nullable|max:140',
                ];
                $messages = [
                    'name.required' => 'Campo evento é obrigatório.',
                    'name.max' => 'Campo evento não pode ter mais do que 240 caracteres.',
                    'sub_title.max' => 'Campo sub-titulo não pode ter mais do que 240 caracteres.',
                    'linkIngressos.max' => 'Campo link ingressos não pode ter mais do que 240 caracteres.',
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
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:240',
                    'sub_title' => 'nullable|max:240',
                    'telefone' => 'nullable|max:20',
                    'linkIngressos' => 'nullable|max:240',
                    'title_banner' => 'nullable|max:240',
                    'legendaBannerPrincipal' => 'nullable|max:240',
                    'legendaImagemPrincipal' => 'nullable|max:240',
                    'fileBannerPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'fileImagemPrincipal.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'filesGaleria.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'namedefault' => 'nullable|max:140',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado.',
                    'name.required' => 'Campo evento é obrigatório.',
                    'name.max' => 'Campo evento não pode ter mais do que 240 caracteres.',
                    'sub_title.max' => 'Campo sub-titulo não pode ter mais do que 240 caracteres.',
                    'linkIngressos.max' => 'Campo link ingressos não pode ter mais do que 240 caracteres.',
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
                ];
                break;
            case 'delete':
                $rules = [
                    'idProgramacao' => 'required'
                ];
                $messages = [
                    'idProgramacao.required' => 'Nenhum registro informado!'
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
                    'idProgramacao' => 'required',
                ];
                $messages = [
                    'id.required' => 'Não foi possível identificar o registro!',
                    'idProgramacao.required' => 'Não foi possível identificar o arquivo a ser excluído!',
                ];
                break;
            case 'delete-galeria':
                $rules = [
                    'idProgramacao' => 'required',
                ];
                $messages = [
                    'idProgramacao.required' => 'Não foi possível identificar a galeria a ser excluída!',
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function register(Request $request)
    {
          $action = $request->input('action');
          $categorias = $request->input('categorias');
          $locais = $request->input('locais');

          $programacao = new Programacao();
          $programacao->name = $request->input('name');
          $programacao->sub_title = $request->input('sub_title');
          $programacao->data = $request->input('data');
          if ($programacao->data)
          {
              $arrayAux = [];
              $arrayDatas = explode(",", $programacao->data);

              foreach ($arrayDatas  as $item)
              {
                  $datetime = new DateTime();
                  $data = $datetime->createFromFormat('d/m/Y', trim($item));
                  $arrayAux[] = $data;
              }

              sort($arrayAux);

              $programacao->data_inicial = $arrayAux[0];
              $programacao->data_final = $arrayAux[count($arrayAux)-1];
              $arrayDatas = [];

              foreach ($arrayAux as $item)
              {
                  $arrayDatas[] = $item->format('d/m/Y');
              }

              $programacao->data = json_encode( $arrayDatas, true );
          }
          else {
              $programacao->data = '[]';
              $programacao->data_inicial = new DateTime();
              $programacao->data_final = new DateTime();
          }
          $programacao->horario = $request->input('horario');
          $programacao->texto_evento = $request->input('textoEvento');
          $programacao->servico = $request->input('servico');
          $programacao->ingressos = $request->input('ingressos');
          $programacao->link_ingresso = $request->input('linkIngressos');
          $programacao->title_banner = $request->input('title_banner');
          $programacao->legenda_banner = $request->input('legendaBanner');
          $programacao->legenda_imagem = $request->input('legendaImagem');

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
              $programacao->banner_principal = $idArray[0];
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
              $programacao->imagem_principal = $idArray[0];
          }
          $programacao->save();

          // -------------------------------------------------------------------
          // Categorias
          // -------------------------------------------------------------------
          $categoriasArray = [];
          if ($request->input('categorias')) { $categoriasArray = explode(",", $request->input('categorias')); }

          if (count($categoriasArray))
          {
              foreach ($categoriasArray as $item)
              {
                  $programacaoHasCategoria = new ProgramacaoHasCategoria();
                  $programacaoHasCategoria->id_programacao = $programacao->id;
                  $programacaoHasCategoria->id_categoria = $item;
                  $programacaoHasCategoria->save();
              }
          }

          // -------------------------------------------------------------------
          // locais
          // -------------------------------------------------------------------
          $locaisArray = [];
          if ($request->input('locais')) { $locaisArray = explode(",", $request->input('locais')); }

          if (count($locaisArray))
          {
              foreach ($locaisArray as $item)
              {
                  $programacaoHasLocal = new ProgramacaoHasLocal();
                  $programacaoHasLocal->id_programacao = $programacao->id;
                  $programacaoHasLocal->id_local = $item;
                  $programacaoHasLocal->save();
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

                  if ($galeriaHasImagem->where('id_programacao', '!=', '')->max('order')) {
                      $idOrder = $galeriaHasImagem->where('id_programacao', '!=', '')->max('order');
                  }
                  $idOrder++;

                  $galeriaHasImagem->id_programacao = $programacao->id;
                  $galeriaHasImagem->id_file = $item;
                  $galeriaHasImagem->order = $idOrder;
                  $galeriaHasImagem->save();
              }
          }

        return true;
    }

    private function delete(Request $request)
    {
        $id = $request->input('idProgramacao');
        $registerDelete = new Programacao();
        $delete = $registerDelete->find($id);
        $programacaoHasCategoria = new ProgramacaoHasCategoria();
        $programacaoCategorias = $programacaoHasCategoria->where('id_programacao', '=', $id);
        $programacaoCategorias->delete();
        $programacaoHasLocal = new ProgramacaoHasLocal();
        $programacaoLocal = $programacaoHasLocal->where('id_programacao', '=', $id);
        $programacaoLocal->delete();


        if ($delete->banner_principal)
        {
            $files = new File();
            $file = $files->find($delete->banner_principal);
            $nameFileFull = $file->namefilefull;
            $nameFileFullThumb = $file->namefilefullthumb;
            if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
            if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

            $file->delete();
        }

        if ($delete->imagem_principal)
        {
            $files = new File();
            $file = $files->find($delete->imagem_principal);
            $nameFileFull = $file->namefilefull;
            $nameFileFullThumb = $file->namefilefullthumb;

            if (file_exists($nameFileFull) ) { unlink($nameFileFull); }
            if (file_exists($nameFileFullThumb) ) { unlink($nameFileFullThumb); }

            $file->delete();
        }

        // Deleta a Galeria reaproveitando a função delete galerias feita no editar abaixo
        $this->deleteGaleria($request);

        $delete->delete();
        return true;
    }







    // ================================================================================
    // ========================== Edição das programacoes =============================
    // ================================================================================


    public function update(Request $request, $id = null)
    {
        $return = ['title' => 'Atualizar Programações'];
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
        $return['casas'] = $casa->listCasas();

        $programacao = new Programacao();
        $return['programacao'] = $programacao->find($id);

        // Retorna as categorias cadastradas
        $programacaoCategorias = new ProgramacaoHasCategoria();
        $return['programacaoCategorias'] = $programacaoCategorias->where('id_programacao', '=', $id)->get();

        // Retorna os locais cadastradas
        $programacaoLocais = new ProgramacaoHasLocal();
        $return['programacaoLocais'] = $programacaoLocais->where('id_programacao', '=', $id)->get();

        // Retorna a banner prinpipal
        $bannerPrincipal = new Programacao();
        $return['bannerPrincipal'] = $bannerPrincipal->returnaBannerPrincipal($id);

        // Retorna a imagem prinpipal
        $imagemPrincipal = new Programacao();
        $return['imagemPrincipal'] = $bannerPrincipal->returnaImagemPrincipal($id);

        // Retorna a galeria
        $galeria = new GaleriaHasFileGaleria();
        $return['galeria'] = $galeria->listGaleriaADM($id, 'galerias_has_files-galeria.id_programacao');

        if(!count($return['programacao']) || !$id) {
            return redirect('/adm/programacoes'); //Se não encontrar o registro volta para listagem
        }

        if($erros)
        {
          return view('adm.programacoes-update')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.programacoes-update')->withReturn($return);
          } else {
              return redirect('/adm/programacoes-edit/'.$id); //Adicionado o redirect para limpar o post
          }
        }
    }



    private function orderImage(Request $request)
    {
      $trueFalse = true;

      $update = new GaleriaHasFileGaleria();
      $edit = $update->where('id_programacao', '=', $request->input('idProgramacao'))->orderBy('order')->get()->toArray();
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
        $idProgramacao = $request->input('idProgramacao');

        $hasImagem = new GaleriaHasFileGaleria();
        $deleteHasImagem = $hasImagem->where('id_programacao', $idProgramacao);

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
        $idProgramacao = $request->input('idProgramacao');

        $hasImagem = new GaleriaHasFileGaleria();
        $deleteHasImagem = $hasImagem->where('id_programacao', $idProgramacao)->where('id', $id)->first();

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
                $register = new Programacao();
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
                $register = new Programacao();
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
          $action = $request->input('action');
          $categorias = $request->input('categorias');
          $locais = $request->input('locais');

          $programacoes = new Programacao();
          $programacao = $programacoes->find($request->input('id'));
          $programacao->name = $request->input('name');
          $programacao->sub_title = $request->input('sub_title');
          // dd($request);
          $programacao->data = $request->input('data');
          if ($programacao->data)
          {
              $arrayAux = [];
              $arrayDatas = explode(",", $programacao->data);

              foreach ($arrayDatas  as $item)
              {
                  $datetime = new DateTime();
                  $data = $datetime->createFromFormat('d/m/Y', trim($item));
                  $arrayAux[] = $data;
              }

              sort($arrayAux);

              $programacao->data_inicial = $arrayAux[0];
              $programacao->data_final = $arrayAux[count($arrayAux)-1];
              $arrayDatas = [];

              foreach ($arrayAux as $item)
              {
                  $arrayDatas[] = $item->format('d/m/Y');
              }

              $programacao->data = json_encode( $arrayDatas, true );
          }
          else {
              $programacao->data = '[]';
              $programacao->data_inicial = $programacao->created_at;
              $programacao->data_final = $programacao->created_at;
          }
          $programacao->horario = $request->input('horario');
          $programacao->texto_evento = $request->input('textoEvento');
          $programacao->servico = $request->input('servico');
          $programacao->ingressos = $request->input('ingressos');
          $programacao->link_ingresso = $request->input('linkIngressos');
          $programacao->title_banner = $request->input('title_banner');
          $programacao->legenda_banner = $request->input('legendaBanner');
          $programacao->legenda_imagem = $request->input('legendaImagem');

          $helpers = new Helpers();

          // -------------------------------------------------------------------
          // FileBannerPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileBannerPrincipal')))
          {
              if ($programacao->banner_principal)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($programacao->banner_principal);
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
              $programacao->banner_principal = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImagemPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileImagemPrincipal')))
          {
              if ($programacao->imagem_principal)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($programacao->imagem_principal);
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
              $programacao->imagem_principal = $idArray[0];
          }
          $programacao->save();

          // -------------------------------------------------------------------
          // Categorias
          // -------------------------------------------------------------------
          $DCHC = new ProgramacaoHasCategoria();
          $DeleteDCHC = $DCHC->where('id_programacao', $programacao->id);
          $DeleteDCHC->delete();

          $categoriasArray = [];
          if ($request->input('categorias')) { $categoriasArray = explode(",", $request->input('categorias')); }

          if (count($categoriasArray))
          {
              foreach ($categoriasArray as $item)
              {
                  $programacaoHasCategoria = new ProgramacaoHasCategoria();
                  $programacaoHasCategoria->id_programacao = $programacao->id;
                  $programacaoHasCategoria->id_categoria = $item;
                  $programacaoHasCategoria->save();
              }
          }

          // -------------------------------------------------------------------
          // Casas
          // -------------------------------------------------------------------
          $DCHL = new ProgramacaoHasLocal();
          $DeleteDCHL = $DCHL->where('id_programacao', $programacao->id);
          $DeleteDCHL->delete();

          $locaisArray = [];
          if ($request->input('locais')) { $locaisArray = explode(",", $request->input('locais')); }

          if (count($locaisArray))
          {
              foreach ($locaisArray as $item)
              {
                  $programacaoHasLocal = new ProgramacaoHasLocal();
                  $programacaoHasLocal->id_programacao = $programacao->id;
                  $programacaoHasLocal->id_local = $item;
                  $programacaoHasLocal->save();
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

                  if ($galeriaHasImagem->where('id_programacao', '!=', '')->max('order')) {
                      $idOrder = $galeriaHasImagem->where('id_programacao', '!=', '')->max('order');
                  }
                  $idOrder++;

                  $galeriaHasImagem->id_programacao = $programacao->id;
                  $galeriaHasImagem->id_file = $item;
                  $galeriaHasImagem->order = $idOrder;
                  $galeriaHasImagem->save();
              }
          }

        return true;
    }

}
