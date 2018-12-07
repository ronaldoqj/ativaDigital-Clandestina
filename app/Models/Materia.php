<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Materia extends Model
{
    private $type = null;
    private $limit = null;
    private $id = null;


    public function setType($type) {
        $this->type = $type;
    }
    public function setLimit($limit) {
        $this->limit = $limit;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // Usado no adm para listar as materias [Página - Materias]
    public function listMaterias()
    {
        $list = DB::table('materias')->leftjoin('files', 'files.id', '=', 'materias.image')
                                    ->where('materias.type', $this->type)
                                    ->orderBy('materias.created_at', 'desc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.ativo as ativo',
                                    'materias.title as title',
                                    'materias.assunto as assunto',
                                    'materias.subtitle as subtitle',
                                    'materias.colunista as colunista',
                                    'materias.category as category',
                                    'materias.video as video',
                                    'materias.galeria as galeria',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.backgroundbanner as backgroundbanner',
                                    'materias.image as image',
                                    'materias.created_at as created_at',
                                    'files.id as file_id',
                                    'files.name as file_name',
                                    'files.alternative_text as file_alternative_text',
                                    'files.path as path',
                                    'files.namefile as namefile',
                                    'files.namefilefull as namefilefull')->get();
         return $listAll;
    }

    public function listMateriasHome()
    {
        if($this->limit)
        {
            $list = DB::table('materias')->leftjoin('files', 'files.id', '=', 'materias.image')
                                       ->where('materias.type', $this->type)
                                       ->limit($this->limit)
                                       ->orderBy('materias.created_at', 'desc');
        }
        else
        {
            $list = DB::table('materias')->leftjoin('files', 'files.id', '=', 'materias.image')
                                       ->where('materias.type', $this->type)
                                       ->orderBy('materias.created_at', 'desc')
                                       ->orderBy('materias.category', 'asc');
        }



          $listAll = $list->addSelect('materias.id as id',
                                      'materias.type as type',
                                      'materias.assunto as assunto',
                                      'materias.title as title',
                                      'materias.subtitle as subtitle',
                                      'materias.colunista as colunista',
                                      'materias.text1 as text1',
                                      'materias.text2 as text2',
                                      'materias.backgroundbanner as backgroundbanner',
                                      'materias.image as image',
                                      'materias.facebook as facebook',
                                      'materias.twitter as twitter',
                                      'materias.whatsapp as whatsapp',
                                      'files.id as file_id',
                                      'files.name as file_name',
                                      'files.alternative_text as file_alternative_text',
                                      'files.path as path',
                                      'files.namefile as namefile',
                                      'files.namefilefull as namefilefull')->get();
           return $listAll;
    }



    public function listMateriasHomeColunistas()
    {
        $list = DB::table('materias')->join('categorias', 'categorias.id', '=', 'materias.category')
                                   ->join('files', 'files.id', '=', 'materias.image')
                                   ->where('categorias.categoria', 'materia')
                                   ->where('materias.type', 'coluna')
                                   ->orderBy('materias.created_at', 'desc')
                                   ->orderBy('materias.category', 'asc')
                                   ->orderBy('categorias.nome', 'asc');

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.title as title',
                                  'materias.subtitle as subtitle',
                                  'materias.colunista as colunista',
                                  'materias.category as category',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.backgroundbanner as backgroundbanner',
                                  'materias.image as image',
                                  'materias.facebook as facebook',
                                  'materias.twitter as twitter',
                                  'materias.whatsapp as whatsapp',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }



    public function listMateriasHomeADM()
    {
        $list = DB::table('materias')->join('categorias', 'categorias.id', '=', 'materias.category')
                                   ->join('files', 'files.id', '=', 'materias.image')
                                   ->where('categorias.categoria', 'materia')
                                   ->where('materias.type', $this->type)
                                   ->orderBy('materias.type', 'asc')
                                   ->orderBy('materias.created_at', 'desc')
                                   ->orderBy('materias.category', 'asc')
                                   ->orderBy('categorias.nome', 'asc');

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.title as title',
                                  'materias.subtitle as subtitle',
                                  'materias.colunista as colunista',
                                  'materias.category as category',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.backgroundbanner as backgroundbanner',
                                  'materias.image as image',
                                  'materias.facebook as facebook',
                                  'materias.twitter as twitter',
                                  'materias.whatsapp as whatsapp',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }


    public function listNoticia()
    {
      $list = DB::table('materias')->leftjoin('categorias', 'categorias.id', '=', 'materias.category')
                                   ->leftjoin('tv_adverso', 'tv_adverso.id', '=', 'materias.video')
                                   ->leftjoin('galerias', 'galerias.id', '=', 'materias.galeria')
                                   ->leftjoin('files', 'files.id', '=', 'materias.image')
                                   ->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner')
                                   ->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista')
                                   ->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar')
                                   ->where('materias.id', $this->id)
                                   ->orderBy('materias.created_at', 'desc')
                                   ->orderBy('materias.category', 'asc');

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.assunto as assunto',
                                  'materias.title as title',
                                  'materias.image as image',
                                  'materias.subtitle as subtitle',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.category as category',
                                  'materias.backgroundbanner as backgroundbanner',

                                  'colunistas.id as colunista_id',
                                  'colunistas.name as colunista_name',
                                  'colunistas.cargo as colunista_cargo',
                                  'colunistas.avatar as colunista_avatar',

                                  'galerias.id as galeria_id',

                                  'avatar.id as avatar_id',
                                  'avatar.namefilefull as avatar_namefilefull',
                                  'avatar.namefile as avatar_namefile',

                                  'tv_adverso.id as video_id',
                                  'tv_adverso.title as video_title',
                                  'tv_adverso.description as video_description',
                                  'tv_adverso.link as video_link',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'filesBackground.id as fileBackground_id',
                                  'filesBackground.name as fileBackground_name',
                                  'filesBackground.alternative_text as fileBackground_alternative_text',
                                  'filesBackground.path as fileBackground_path',
                                  'filesBackground.namefilefull as fileBackground_namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }



    public function listMaisNoticias()
    {
      $list = DB::table('materias')->join('categorias', 'categorias.id', '=', 'materias.category')
                                 ->join('files', 'files.id', '=', 'materias.image')
                                 ->join('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner')
                                 ->whereIn('materias.type', ['normal', 'especial'])
                                 ->whereNotIn('materias.id', [$this->id])
                                 ->orderBy('materias.created_at', 'desc')
                                 ->orderBy('materias.category', 'asc')
                                 ->orderBy('categorias.nome', 'asc')
                                 ->limit(4);

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.title as title',
                                  'materias.image as image',
                                  'materias.subtitle as subtitle',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.category as category',
                                  'materias.backgroundbanner as backgroundbanner',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'filesBackground.id as fileBackground_id',
                                  'filesBackground.name as fileBackground_name',
                                  'filesBackground.alternative_text as fileBackground_alternative_text',
                                  'filesBackground.path as fileBackground_path',
                                  'filesBackground.namefilefull as fileBackground_namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }


    public function listMaisColunas()
    {
      $list = DB::table('materias')->join('categorias', 'categorias.id', '=', 'materias.category')
                                 ->join('files', 'files.id', '=', 'materias.image')
                                 ->join('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner')
                                 ->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista')
                                 ->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar')
                                 ->whereIn('materias.type', ['coluna'])
                                 ->whereNotIn('materias.id', [$this->id])
                                 ->orderBy('materias.created_at', 'desc')
                                 ->orderBy('materias.category', 'asc')
                                 ->orderBy('categorias.nome', 'asc')
                                 ->limit(4);

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.title as title',
                                  'materias.image as image',
                                  'materias.subtitle as subtitle',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.category as category',
                                  'materias.backgroundbanner as backgroundbanner',

                                  'colunistas.id as colunista_id',
                                  'colunistas.name as colunista_name',
                                  'colunistas.cargo as colunista_cargo',
                                  'colunistas.avatar as colunista_avatar',

                                  'avatar.id as avatar_id',
                                  'avatar.namefilefull as avatar_namefilefull',
                                  'avatar.namefile as avatar_namefile',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'filesBackground.id as fileBackground_id',
                                  'filesBackground.name as fileBackground_name',
                                  'filesBackground.alternative_text as fileBackground_alternative_text',
                                  'filesBackground.path as fileBackground_path',
                                  'filesBackground.namefilefull as fileBackground_namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }



    public function listColunistasOutros()
    {
      $list = DB::table('colunistas')->leftjoin('files', 'files.id', '=', 'colunistas.avatar')
                                   ->orderBy('colunistas.created_at', 'desc');

      $listAll = $list->addSelect('colunistas.id as id',
                                  'colunistas.name as name',
                                  'colunistas.cargo as cargo',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull')->get();
                                  return $listAll;
    }

    public function listColunas()
    {
      $list = DB::table('materias')->leftjoin('files', 'files.id', '=', 'materias.image')
                                   ->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner')
                                   ->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista')
                                   ->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar')
                                   ->whereIn('materias.type', ['coluna'])
                                   ->orderBy('materias.created_at', 'desc');

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.assunto as assunto',
                                  'materias.title as title',
                                  'materias.image as image',
                                  'materias.subtitle as subtitle',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.backgroundbanner as backgroundbanner',

                                  'colunistas.id as colunista_id',
                                  'colunistas.name as colunista_name',
                                  'colunistas.cargo as colunista_cargo',
                                  'colunistas.avatar as colunista_avatar',

                                  'avatar.id as avatar_id',
                                  'avatar.namefilefull as avatar_namefilefull',
                                  'avatar.namefile as avatar_namefile',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'filesBackground.id as fileBackground_id',
                                  'filesBackground.name as fileBackground_name',
                                  'filesBackground.alternative_text as fileBackground_alternative_text',
                                  'filesBackground.path as fileBackground_path',
                                  'filesBackground.namefilefull as fileBackground_namefilefull')->get();
                                  return $listAll;
    }

}
