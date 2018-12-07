<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\ProgramacaoHasCategoria;
use App\Models\Programacao;
use App\Models\CasasHasCategoria;
use App\Models\Casa;
use App\Models\NoticiasHasCategoria;
use App\Models\Noticia;
use Validator;
use Classes\Helpers;
// use Classes\FiltersIntervention;
use Intervention\Image\Filters\FilterInterface;

// use Intervention\Image\Filters\FilterInterface as Image;
use Intervention\Image\ImageManagerStatic as Image;

class CategoriasController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Categorias'];
        $erros = false;
        $firstCall = true;

        if ($request->isMethod('post'))
        {
            $firstCall = false;
            $validator = $this->validator($request);

            if (!$validator->fails())
            {
                if ($request->input('action') == 'register') {
                    if($this->register($request)) {}
                }

                if ($request->input('action') == 'edit') {
                    if($this->edit($request)) {}
                }

                if ($request->input('action') == 'delete') {
                    if($this->delete($request)) {}
                }
                return redirect('/adm/categorias'); //Adicionado o redirect para limpar o post
            }
            else
            {
              $erros = true;
            }
        }


        $Categorias = new Categoria();
        $categorias = $Categorias->all();
        $return['categorias'] = $categorias;

        if($erros)
        {
          return view('adm.categorias')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.categorias')->withReturn($return);
          } else {
              return redirect('/adm/categorias'); //Adicionado o redirect para limpar o post
          }
        }

    }


    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'name' => 'required|max:140',
                    'color' => 'required',
                    'files.*' => 'required|image|dimensions:min_width=5,min_height=5',
                    'nameImage' => 'nullable|max:140',
                ];
                $messages = [
                    'name.required' => 'Campo nome da categoria é obrigatório.',
                    'name.max' => 'Nome da categoria não pode ter mais do que 140 caracteres.',
                    'nameImage.max' => 'Nome da categoria não pode ter mais do que 140 caracteres.',
                    'color.required' => 'Obrigatório selecionar uma cor para galeria.',
                    'files.*.image' => 'Para o campo imagem só é permitido arquivos do tipo imagem.',
                    'files.*.dimensions' => 'As imagens não pode ser de dimensões inferiores que 5x5.',
                    'files.*.required' => 'É obrigatório selecionar uma imagem.',
                    'title.max' => 'Nome da galeria não pode ter mais do que 240 caracteres.',
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:140',
                    'color' => 'required',
                    'files.*' => 'nullable|image|dimensions:min_width=5,min_height=5',
                    'nameImage' => 'nullable|max:140',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado.',
                    'name.required' => 'Campo nome da categoria é obrigatório.',
                    'name.max' => 'Nome da categoria não pode ter mais do que 140 caracteres.',
                    'nameImage.max' => 'Nome da categoria não pode ter mais do que 140 caracteres.',
                    'color.required' => 'Obrigatório selecionar uma cor para galeria.',
                    'files.*.image' => 'Para o campo imagem só é permitido arquivos do tipo imagem.',
                    'files.*.dimensions' => 'As imagens não pode ser de dimensões inferiores que 5x5.',
                    'title.max' => 'Nome da galeria não pode ter mais do que 240 caracteres.',
                ];
                break;
            case 'delete':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
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
          foreach ($request->file('files') as $fileItem)
          {
              $categoria = new Categoria();

              $categoria->name = $request->input('name');
              $categoria->color = $request->input('color');
              $categoria->description = $request->input('description');
              $categoria->namefile = $request->input('nameImage');

              $helpers = new Helpers();
              $file = $helpers->loadImg( $fileItem );
              $nameImg = str_slug(str_before($file['OriginalName'], '.'), '-');
              $nameImgNew = $nameImg .
                            '_' . time() .
                            '.' . $file['OriginalExtension'];
              $path = 'images/_Categorias';

              $file['File']->move($path, $nameImgNew);
              // $img = Image::make($path.'/'.$nameImgNew);
              // $img->blur(55);

              // Save registers in bank
              if( file_exists($path.'/'.$nameImgNew) )
              {
                  // Registering the images
                  $categoria->path = $path;
                  $categoria->namefileOriginal = $nameImg;
                  $categoria->namefilefull = $path.'/'.$nameImgNew;

                  $categoria->mimetype = $file['MimeType'];
                  $categoria->extension = $file['OriginalExtension'];
                  $categoria->size = $file['Size'];

                  $categoria->save();
              }
          }


      return true;
    }


    private function edit(Request $request)
    {
          $categoria = new Categoria();
          $edit = $categoria->find($request->input('id'));

          $edit->name = $request->input('name');
          $edit->color = $request->input('color');
          $edit->description = $request->input('description');
          $edit->namefile = $request->input('nameImage');

          if ( $request->file('files') )
          {
              foreach ($request->file('files') as $fileItem)
              {
                  if ( file_exists($edit->namefilefull) ) {
                      unlink($edit->namefilefull);
                  }

                  $helpers = new Helpers();
                  $file = $helpers->loadImg( $fileItem );
                  $nameImg = str_slug(str_before($file['OriginalName'], '.'), '-');
                  $nameImgNew = $nameImg .
                                '_' . time() .
                                '.' . $file['OriginalExtension'];
                  $path = 'images/_Categorias';

                  $file['File']->move($path, $nameImgNew);

                  // Save registers in bank
                  if( file_exists($path.'/'.$nameImgNew) )
                  {
                      // Registering the images
                      $edit->path = $path;
                      $edit->namefileOriginal = $nameImg;
                      $edit->namefilefull = $path.'/'.$nameImgNew;

                      $edit->mimetype = $file['MimeType'];
                      $edit->extension = $file['OriginalExtension'];
                      $edit->size = $file['Size'];
                  }
              }
          }
          $edit->save();
          return true;
    }


    private function validaDelete (Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';
        $Categoria = new Categoria();
        $categoria = $Categoria->find($request->input('id'));
        $this->msgErros = '';

        if (!$categoria)
        {
            $erro = true;
            $Mensagem = 'Não foi encontrado nenhuma categoria no Banco de Imagens';
            $this->msgErros = $Mensagem;
        }
        else
        {
            // Verifica Programação
            $Verifica = new ProgramacaoHasCategoria();
            $verifica = $Verifica->all()->where('id_categoria', $categoria->id);
            $Mensagem = '';

            if( count($verifica) )
            {
                $erro = true;
                $Mensagem .= 'A categoria está sendo utilizada nas seguintes programações:';
                $Mensagem .= '<ul>';

                foreach($verifica as $item) {
                    $Programacao = new Programacao();
                    $programacao = $Programacao->find($item->id_programacao);
                    $Mensagem .= '<li>'. $programacao->name .'.</li>';
                }

                $Mensagem .= '</ul>';
            }

            // Verifica as Casas
            $Verifica = new CasasHasCategoria();
            $verifica = $Verifica->all()->where('id_categoria', $categoria->id);

            if( count($verifica) )
            {
                $erro = true;
                if ( $Mensagem != '' ) { $Mensagem .= '<br />'; }
                $Mensagem .= 'A categoria está sendo utilizada nas seguintes casas:';
                $Mensagem .= '<ul>';

                foreach($verifica as $item) {
                    $Casa = new Casa();
                    $casa = $Casa->find($item->id_casa);
                    $Mensagem .= '<li>'. $casa->name .'.</li>';
                }

                $Mensagem .= '</ul>';
            }

            // Verifica as Notícias
            $Verifica = new NoticiasHasCategoria();
            $verifica = $Verifica->all()->where('id_categoria', $categoria->id);

            if( count($verifica) )
            {
                $erro = true;
                if ($Mensagem != '') { $Mensagem .= '<br />'; }
                $Mensagem .= 'A categoria está sendo utilizada nas seguintes noticias:';
                $Mensagem .= '<ul>';

                foreach($verifica as $item) {
                    $Noticia = new Noticia();
                    $noticia = $Noticia->find($item->id_noticia);
                    $Mensagem .= '<li>'. $noticia->name .'.</li>';
                }

                $Mensagem .= '</ul>';
            }
        }

        $this->msgErros = $Mensagem;
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
        dd('Não é para vir aqui');
        $categoria = new Categoria();
        $id = $request->input('id');
        if ($id != '')
        {
            $delete = $categoria->find($id);
            if( file_exists($delete->namefilefull) )
            {
                unlink($delete->namefilefull);
                $delete->delete();
            }
        }

        return true;
    }

}
