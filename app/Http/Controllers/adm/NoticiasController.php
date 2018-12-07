<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Noticia;
use App\Models\File;
use App\Models\FilesGaleria;
use App\Models\NoticiasHasCategoria;
use App\Models\GaleriaHasFileGaleria;
use Classes\Helpers;
use Validator;
use DB;

class NoticiasController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Notícias'];
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

        $noticia = new Noticia();
        $return['noticias'] = $noticia->listNoticias();
        if($erros)
        {
          return view('adm.noticias')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.noticias')->withReturn($return);
          } else {
              return redirect('/adm/noticias'); //Adicionado o redirect para limpar o post
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
                    'sub_title.max' => 'Campo sub-titulo não pode ter mais do que 240 caracteres.',
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
                    'sub_title.max' => 'Campo sub-titulo não pode ter mais do que 240 caracteres.',
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
                    'idNoticia' => 'required'
                ];
                $messages = [
                    'idNoticia.required' => 'Nenhum registro informado!'
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
                    'idNoticia' => 'required',
                ];
                $messages = [
                    'id.required' => 'Não foi possível identificar o registro!',
                    'idNoticia.required' => 'Não foi possível identificar o arquivo a ser excluído!',
                ];
                break;
            case 'delete-galeria':
                $rules = [
                    'idNoticia' => 'required',
                ];
                $messages = [
                    'idNoticia.required' => 'Não foi possível identificar a galeria a ser excluída!',
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function register(Request $request)
    {
          $noticia = new Noticia();
          $noticia->pelicula = $request->input('pelicula');
          $noticia->name = $request->input('name');
          $noticia->sub_title = $request->input('sub_title');
          $noticia->title_banner = $request->input('title_banner');
          $noticia->legenda_banner = $request->input('legendaBanner');
          $noticia->legenda_imagem = $request->input('legendaImagem');
          $noticia->texto = $request->input('texto');
          $noticia->texto2 = $request->input('texto2');
          $noticia->site = $request->input('site');
          $noticia->facebook = $request->input('facebook');
          $noticia->twitter = $request->input('twitter');
          $noticia->instagram = $request->input('instagram');
          $noticia->whatsapp = $request->input('whatsapp');
          $noticia->youtube = $request->input('youtube');

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
              $noticia->banner_principal = $idArray[0];
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
              $noticia->imagem_principal = $idArray[0];
          }
          $noticia->save();

          // -------------------------------------------------------------------
          // Categorias
          // -------------------------------------------------------------------
          $categoriasArray = [];
          if ($request->input('categorias')) { $categoriasArray = explode(",", $request->input('categorias')); }

          if (count($categoriasArray))
          {
              foreach ($categoriasArray as $item)
              {
                  $noticiasHasCategoria = new NoticiasHasCategoria();
                  $noticiasHasCategoria->id_noticia = $noticia->id;
                  $noticiasHasCategoria->id_categoria = $item;
                  $noticiasHasCategoria->save();
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

                  if ($galeriaHasImagem->where('id_noticia', '!=', '')->max('order')) {
                      $idOrder = $galeriaHasImagem->where('id_noticia', '!=', '')->max('order');
                  }
                  $idOrder++;

                  $galeriaHasImagem->id_noticia = $noticia->id;
                  $galeriaHasImagem->id_file = $item;
                  $galeriaHasImagem->order = $idOrder;
                  $galeriaHasImagem->save();
              }
          }

        return true;
    }

    private function delete(Request $request)
    {
        $id = $request->input('idNoticia');
        $noticiasHasCategoria = new NoticiasHasCategoria();
        $noticiasCategorias = $noticiasHasCategoria->where('id_noticia', '=', $id);
        $noticiasCategorias->delete();
        $registerDelete = new Noticia();
        $delete = $registerDelete->find($id);

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
    // ========================== Edição das noticias =================================
    // ================================================================================


    public function update(Request $request, $id = null)
    {
        $return = ['title' => 'Atualizar Notícias'];
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

        $noticia = new Noticia();
        $return['noticia'] = $noticia->find($id);

        // Retorna as categorias cadastradas
        $noticiaCategorias = new NoticiasHasCategoria();
        $return['noticiaCategorias'] = $noticiaCategorias->where('id_noticia', '=', $id)->get();

        // Retorna a banner prinpipal
        $bannerPrincipal = new Noticia();
        $return['bannerPrincipal'] = $bannerPrincipal->returnaBannerPrincipal($id);

        // Retorna a imagem prinpipal
        $imagemPrincipal = new Noticia();
        $return['imagemPrincipal'] = $bannerPrincipal->returnaImagemPrincipal($id);

        // Retorna a galeria
        $galeria = new GaleriaHasFileGaleria();
        $return['galeria'] = $galeria->listGaleriaADM($id, 'galerias_has_files-galeria.id_noticia');

        if(!count($return['noticia']) || !$id) {
            return redirect('/adm/noticias'); //Se não encontrar o registro volta para listagem
        }

        if($erros)
        {
          return view('adm.noticias-update')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.noticias-update')->withReturn($return);
          } else {
              return redirect('/adm/noticia-edit/'.$id); //Adicionado o redirect para limpar o post
          }
        }
    }



    private function orderImage(Request $request)
    {
      $trueFalse = true;

      $update = new GaleriaHasFileGaleria();
      $edit = $update->where('id_noticia', '=', $request->input('idNoticia'))->orderBy('order')->get()->toArray();
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
        $idNoticia = $request->input('idNoticia');

        $hasImagem = new GaleriaHasFileGaleria();
        $deleteHasImagem = $hasImagem->where('id_noticia', $idNoticia);

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
        $idNoticia = $request->input('idNoticia');

        $hasImagem = new GaleriaHasFileGaleria();
        $deleteHasImagem = $hasImagem->where('id_noticia', $idNoticia)->where('id', $id)->first();

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
                $register = new Noticia();
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
                $register = new Noticia();
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
          $noticias = new Noticia();
          $noticia = $noticias->find($request->input('id'));
          $noticia->pelicula = $request->input('pelicula');
          $noticia->name = $request->input('name');
          $noticia->sub_title = $request->input('sub_title');
          $noticia->title_banner = $request->input('title_banner');
          $noticia->legenda_banner = $request->input('legendaBanner');
          $noticia->legenda_imagem = $request->input('legendaImagem');
          $noticia->texto = $request->input('texto');
          $noticia->texto2 = $request->input('texto2');
          $noticia->site = $request->input('site');
          $noticia->facebook = $request->input('facebook');
          $noticia->twitter = $request->input('twitter');
          $noticia->instagram = $request->input('instagram');
          $noticia->whatsapp = $request->input('whatsapp');
          $noticia->youtube = $request->input('youtube');

          $helpers = new Helpers();

          // -------------------------------------------------------------------
          // FileBannerPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileBannerPrincipal')))
          {
              if ($noticia->banner_principal)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($noticia->banner_principal);
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
              $noticia->banner_principal = $idArray[0];
          }
          // -------------------------------------------------------------------
          // FileImagemPrincipal
          // -------------------------------------------------------------------
          if (count($request->file('fileImagemPrincipal')))
          {
              if ($noticia->imagem_principal)
              {
                  // Deleta imagem existente
                  $files = new File();
                  $file = $files->find($noticia->imagem_principal);
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
              $noticia->imagem_principal = $idArray[0];
          }
          $noticia->save();

          // -------------------------------------------------------------------
          // Categorias
          // -------------------------------------------------------------------
          $DCHC = new NoticiasHasCategoria();
          $DeleteDCHC = $DCHC->where('id_noticia', $noticia->id);
          $DeleteDCHC->delete();

          $categoriasArray = [];
          if ($request->input('categorias')) { $categoriasArray = explode(",", $request->input('categorias')); }

          if (count($categoriasArray))
          {
              foreach ($categoriasArray as $item)
              {
                  $noticiasHasCategoria = new NoticiasHasCategoria();
                  $noticiasHasCategoria->id_noticia = $noticia->id;
                  $noticiasHasCategoria->id_categoria = $item;
                  $noticiasHasCategoria->save();
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

                  if ($galeriaHasImagem->where('id_noticia', '!=', '')->max('order')) {
                      $idOrder = $galeriaHasImagem->where('id_noticia', '!=', '')->max('order');
                  }
                  $idOrder++;

                  $galeriaHasImagem->id_noticia = $noticia->id;
                  $galeriaHasImagem->id_file = $item;
                  $galeriaHasImagem->order = $idOrder;
                  $galeriaHasImagem->save();
              }
          }

        return true;
    }

}
