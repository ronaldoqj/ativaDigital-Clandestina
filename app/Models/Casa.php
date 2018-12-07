<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Casa extends Model
{

    // Site
    public function siteBannersCasas($params = [])
    {
        // Valor negativo retorna todos
        // Valor negativo retorna todos
        $limit = $params['limit'] ?? -1;

        $list = DB::table('casas');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal');
        $list->where('casas.banner', 'S');
        $list->addSelect( 'casas.id as id',
                           'order',
                           'casas.name as name',
                           'title_banner',
                           'legenda_banner',
                           DB::raw('"" as data'),
                           'banner_principal.namefilefull as banner_principal_namefilefull' );


        $list->orderBy(DB::raw('IFNULL(casas.order, 4199999999 )', 'ASC'));

        // Trata Calendário
        $listAll = $list->get();
        if ($listAll->count())
        {
              $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];
              foreach($listAll as $item)
              {
                  $data = json_decode($item->data);

                  if (count($data))
                  {
                        $calendario = [];
                        if ( count($data) > 2 )
                        {
                              $pos1 = explode("/", $data[0]);
                              $pos3 = explode("/", $data[count($data) - 1]);

                              $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]] ];
                              $calendario[] = 'A';
                              $calendario[] = [ 'dia' => $pos3[0], 'mes' => $nomeMeses[$pos3[1]] ];
                        }
                        elseif ( count($data) > 1 )
                        {
                              $pos1 = explode("/", $data[0]);
                              $pos3 = explode("/", $data[count($data) - 1]);

                              $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]] ];
                              $calendario[] = 'E';
                              $calendario[] = [ 'dia' => $pos3[0], 'mes' => $nomeMeses[$pos3[1]] ];
                        }
                        else
                        {
                              $pos1 = explode("/", $data[0]);
                              $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]] ];
                        }

                        $item->calendario = $calendario;
                  }
                  else
                  {
                      $item->calendario = [];
                  }
              }
        }

        return $listAll;
    }
    // public function siteBannersCasas($params = [])
    // {
    //     // Valor negativo retorna todos
    //     $limit = $params['limit'] ?? -1;
    //
    //     $list = DB::table('casas');
    //     $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal');
    //     $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal');
    //     $casas = new Casa();
    //     $casasAll = $casas->where('banner', 'S');
    //     if ($casasAll->get()->count())
    //     {
    //         $list->where('casas.banner', 'S');
    //     }
    //     else {
    //         $list->limit($limit);
    //     }
    //     $list->orderBy('casas.created_at', 'desc');
    //
    //     $listAll = $list->addSelect('casas.*',
    //                                 'casas.id as id',
    //
    //                                 'banner_principal.id as banner_principal_id',
    //                                 'banner_principal.name as banner_principal_name',
    //                                 'banner_principal.description as banner_principal_description',
    //                                 'banner_principal.alternative_text as banner_principal_alternative_text',
    //                                 'banner_principal.path as banner_principal_path',
    //                                 'banner_principal.namefile as banner_principal_namefile',
    //                                 'banner_principal.namefilefull as banner_principal_namefilefull',
    //                                 'banner_principal.paththumb as banner_principal_paththumb',
    //                                 'banner_principal.namefilethumb as banner_principal_namefilethumb',
    //                                 'banner_principal.namefilefullthumb as banner_principal_namefilefullthumb',
    //
    //                                 'imagem_principal.id as imagem_principal_id',
    //                                 'imagem_principal.name as imagem_principal_name',
    //                                 'imagem_principal.description as imagem_principal_description',
    //                                 'imagem_principal.alternative_text as imagem_principal_alternative_text',
    //                                 'imagem_principal.path as imagem_principal_path',
    //                                 'imagem_principal.namefile as imagem_principal_namefile',
    //                                 'imagem_principal.namefilefull as imagem_principal_namefilefull',
    //                                 'imagem_principal.paththumb as imagem_principal_paththumb',
    //                                 'imagem_principal.namefilethumb as imagem_principal_namefilethumb',
    //                                 'imagem_principal.namefilefullthumb as imagem_principal_namefilefullthumb'
    //                                 )->get();
    //
    //      return $listAll;
    // }

    public function siteCasas($params = [])
    {
        // Valor negativo retorna todos
        $limit = $params['limit'] ?? -1;

        $list = DB::table('casas')->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal')
                                         ->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal')
                                         // ->leftjoin('programacao_has_categoria', 'programacao_has_categoria.id_programacao', '=', 'casas.id')
                                         // ->leftjoin('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                         ->limit($limit)
                                         ->orderBy('casas.created_at', 'desc');



        $listAll = $list->addSelect('casas.*',
                                    'casas.id as id',
                                    //
                                    // 'categorias.color as categoria_color',
                                    // 'categorias.namefilefull as categoria_namefilefull',
                                    //
                                    'banner_principal.id as banner_principal_id',
                                    'banner_principal.name as banner_principal_name',
                                    'banner_principal.description as banner_principal_description',
                                    'banner_principal.alternative_text as banner_principal_alternative_text',
                                    'banner_principal.path as banner_principal_path',
                                    'banner_principal.namefile as banner_principal_namefile',
                                    'banner_principal.namefilefull as banner_principal_namefilefull',
                                    'banner_principal.paththumb as banner_principal_paththumb',
                                    'banner_principal.namefilethumb as banner_principal_namefilethumb',
                                    'banner_principal.namefilefullthumb as banner_principal_namefilefullthumb',

                                    'imagem_principal.id as imagem_principal_id',
                                    'imagem_principal.name as imagem_principal_name',
                                    'imagem_principal.description as imagem_principal_description',
                                    'imagem_principal.alternative_text as imagem_principal_alternative_text',
                                    'imagem_principal.path as imagem_principal_path',
                                    'imagem_principal.namefile as imagem_principal_namefile',
                                    'imagem_principal.namefilefull as imagem_principal_namefilefull',
                                    'imagem_principal.paththumb as imagem_principal_paththumb',
                                    'imagem_principal.namefilethumb as imagem_principal_namefilethumb',
                                    'imagem_principal.namefilefullthumb as imagem_principal_namefilefullthumb'
                                    )->get();

         if ($listAll->count())
         {
              foreach($listAll as $item)
              {
                    $list = DB::table('casa_has_categoria')
                                      ->join('categorias', 'categorias.id', '=', 'casa_has_categoria.id_categoria')
                                      ->where('casa_has_categoria.id_casa', $item->id);

                    $item->categorias = $list->addSelect('categorias.*')->get();
              }
         }

         return $listAll;
    }

    public function siteCasa($id)
    {
        // Valor negativo retorna todos


        $list = DB::table('casas')->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal')
                                         ->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal')
                                         // ->leftjoin('programacao_has_categoria', 'programacao_has_categoria.id_programacao', '=', 'casas.id')
                                         // ->leftjoin('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                         ->where('casas.id', '=', $id)
                                         ->orderBy('casas.created_at', 'desc');



        $listAll = $list->addSelect('casas.*',
                                    'casas.id as id',
                                    //
                                    // 'categorias.color as categoria_color',
                                    // 'categorias.namefilefull as categoria_namefilefull',
                                    //
                                    'banner_principal.id as banner_principal_id',
                                    'banner_principal.name as banner_principal_name',
                                    'banner_principal.description as banner_principal_description',
                                    'banner_principal.alternative_text as banner_principal_alternative_text',
                                    'banner_principal.path as banner_principal_path',
                                    'banner_principal.namefile as banner_principal_namefile',
                                    'banner_principal.namefilefull as banner_principal_namefilefull',
                                    'banner_principal.paththumb as banner_principal_paththumb',
                                    'banner_principal.namefilethumb as banner_principal_namefilethumb',
                                    'banner_principal.namefilefullthumb as banner_principal_namefilefullthumb',

                                    'imagem_principal.id as imagem_principal_id',
                                    'imagem_principal.name as imagem_principal_name',
                                    'imagem_principal.description as imagem_principal_description',
                                    'imagem_principal.alternative_text as imagem_principal_alternative_text',
                                    'imagem_principal.path as imagem_principal_path',
                                    'imagem_principal.namefile as imagem_principal_namefile',
                                    'imagem_principal.namefilefull as imagem_principal_namefilefull',
                                    'imagem_principal.paththumb as imagem_principal_paththumb',
                                    'imagem_principal.namefilethumb as imagem_principal_namefilethumb',
                                    'imagem_principal.namefilefullthumb as imagem_principal_namefilefullthumb'
                                    )->get();

         if ($listAll->count())
         {
                $list = DB::table('casa_has_categoria')
                                  ->join('categorias', 'categorias.id', '=', 'casa_has_categoria.id_categoria')
                                  ->where('casa_has_categoria.id_casa', $listAll[0]->id);

                $listAll[0]->categorias = $list->addSelect('categorias.*')->get();
         }

         return $listAll[0];
    }

    public function siteCasaGaleria($id)
    {
        $list = DB::table('galerias_has_files-galeria')->join('files-galeria', 'files-galeria.id', '=', 'galerias_has_files-galeria.id_file')
                                         ->where('galerias_has_files-galeria.id_casa', $id);

        $listAll = $list->addSelect('files-galeria.id as id',
                                    'files-galeria.name as file_name',
                                    'files-galeria.description as file_description',
                                    'files-galeria.alternative_text as file_alternative_text',
                                    'files-galeria.path as file_path',
                                    'files-galeria.namefile as file_namefile',
                                    'files-galeria.namefilefull as file_namefilefull',
                                    'files-galeria.paththumb as file_paththumb',
                                    'files-galeria.namefilethumb as file_namefilethumb',
                                    'files-galeria.namefilefullthumb as file_namefilefullthumb')->get();

         return $listAll;
    }

    // ADM
    public function listCasas()
    {
        $list = DB::table('casas')->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal')
                                  ->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal')
                                   ->orderBy('casas.created_at', 'desc');

        $listAll = $list->addSelect('casas.*',
                                    'casas.id as id',

                                    'banner_principal.id as banner_principal_id',
                                    'banner_principal.name as banner_principal_name',
                                    'banner_principal.description as banner_principal_description',
                                    'banner_principal.alternative_text as banner_principal_alternative_text',
                                    'banner_principal.path as banner_principal_path',
                                    'banner_principal.namefile as banner_principal_namefile',
                                    'banner_principal.namefilefull as banner_principal_namefilefull',
                                    'banner_principal.paththumb as banner_principal_paththumb',
                                    'banner_principal.namefilethumb as banner_principal_namefilethumb',
                                    'banner_principal.namefilefullthumb as banner_principal_namefilefullthumb',

                                    'imagem_principal.id as imagem_principal_id',
                                    'imagem_principal.name as imagem_principal_name',
                                    'imagem_principal.description as imagem_principal_description',
                                    'imagem_principal.alternative_text as imagem_principal_alternative_text',
                                    'imagem_principal.path as imagem_principal_path',
                                    'imagem_principal.namefile as imagem_principal_namefile',
                                    'imagem_principal.namefilefull as imagem_principal_namefilefull',
                                    'imagem_principal.paththumb as imagem_principal_paththumb',
                                    'imagem_principal.namefilethumb as imagem_principal_namefilethumb',
                                    'imagem_principal.namefilefullthumb as imagem_principal_namefilefullthumb'
                                    )->get();
         return $listAll;
    }

    public function returnaBannerPrincipal($id)
    {
        $list = DB::table('casas')->join('files', 'files.id', '=', 'casas.banner_principal')
                                  ->where('casas.id', $id);

        $return = $list->addSelect('casas.*',
                                    'casas.id as id',

                                    'files.id as banner_principal_id',
                                    'files.name as banner_principal_name',
                                    'files.description as banner_principal_description',
                                    'files.alternative_text as banner_principal_alternative_text',
                                    'files.path as banner_principal_path',
                                    'files.namefile as banner_principal_namefile',
                                    'files.namefilefull as banner_principal_namefilefull',
                                    'files.paththumb as banner_principal_paththumb',
                                    'files.namefilethumb as banner_principal_namefilethumb',
                                    'files.namefilefullthumb as banner_principal_namefilefullthumb')->get();
         return $return;
    }
    public function returnaImagemPrincipal($id)
    {
        $list = DB::table('casas')->join('files', 'files.id', '=', 'casas.imagem_principal')
                                  ->where('casas.id', $id);

        $return = $list->addSelect('casas.*',
                                    'casas.id as id',

                                    'files.id as imagem_principal_id',
                                    'files.name as imagem_principal_name',
                                    'files.description as imagem_principal_description',
                                    'files.alternative_text as imagem_principal_alternative_text',
                                    'files.path as imagem_principal_path',
                                    'files.namefile as imagem_principal_namefile',
                                    'files.namefilefull as imagem_principal_namefilefull',
                                    'files.paththumb as imagem_principal_paththumb',
                                    'files.namefilethumb as imagem_principal_namefilethumb',
                                    'files.namefilefullthumb as imagem_principal_namefilefullthumb')->get();
         return $return;
    }
}
