<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Programacao;
use App\Models\Newsletter;
use DB;
use DateTime;
use DateInterval;

class Programacao extends Model
{
    protected $table = 'programacoes';


    public function siteBannersHome($params = [])
    {
        // Valor negativo retorna todos
        $limit = $params['limit'] ?? -1;

        $list = DB::table('programacoes');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal');
        $list->where('programacoes.home', 'S');
        $list->addSelect( 'programacoes.id as id',
                          'order_home',
                          DB::raw('"programacoes" as tabela'),
                          'programacoes.name as name',
                          'title_banner',
                          'legenda_banner',
                          'programacoes.data as data',
                          'banner_principal.namefilefull as banner_principal_namefilefull' );

        $list2 = DB::table('noticias');
        $list2->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'noticias.banner_principal');
        $list2->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'noticias.imagem_principal');
        $list2->where('noticias.home', 'S');
        $list2->addSelect( 'noticias.id as id',
                           'order_home',
                           DB::raw('"noticias" as tabela'),
                           'noticias.name as name',
                           'title_banner',
                           'legenda_banner',
                           DB::raw('"" as data'),
                           'banner_principal.namefilefull as banner_principal_namefilefull' );

        $list3 = DB::table('casas');
        $list3->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal');
        $list3->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal');
        $list3->where('casas.home', 'S');
        $list3->addSelect( 'casas.id as id',
                           'order_home',
                           DB::raw('"casas" as tabela'),
                           'casas.name as name',
                           'title_banner',
                           'legenda_banner',
                           DB::raw('"" as data'),
                           'banner_principal.namefilefull as banner_principal_namefilefull' );

        $list3->union($list);
        $list3->union($list2);
        $list3->orderBy(DB::raw('IFNULL(order_home, 4199999999 )', 'ASC'));

        // Trata Calendário
        $listAll = $list3->get();
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


    public function siteBannersAgenda($params = [])
    {
        // Valor negativo retorna todos
        $limit = $params['limit'] ?? -1;

        $list = DB::table('programacoes');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal');
        $list->where('programacoes.banner', 'S');
        $list->addSelect( 'programacoes.id as id',
                          'programacoes.order',
                          'programacoes.name as name',
                          'title_banner',
                          'legenda_banner',
                          'programacoes.data as data',
                          'banner_principal.namefilefull as banner_principal_namefilefull' );


        $list->orderBy(DB::raw('IFNULL(programacoes.order, 4199999999 )', 'ASC'));

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
    // public function siteBannersHome($params = [])
    // {
    //     // Valor negativo retorna todos
    //     $limit = $params['limit'] ?? -1;
    //
    //     $list = DB::table('programacoes');
    //     $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal');
    //     $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal');
    //
    //     $programacao = new Programacao();
    //     $programacaoAll = $programacao->where('banner', 'S');
    //     if ($programacaoAll->get()->count())
    //     {
    //         $list->where('programacoes.banner', 'S');
    //     }
    //     else {
    //         $list->limit($limit);
    //     }
    //
    //     $list->orderBy('programacoes.created_at', 'desc');
    //
    //     $listAll = $list->addSelect('programacoes.*',
    //                                 'programacoes.id as id',
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
    //     // Trata Calendário
    //     if ($listAll->count())
    //     {
    //           $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];
    //           foreach($listAll as $item)
    //           {
    //
    //               $data = json_decode($item->data);
    //
    //               if (count($data))
    //               {
    //                     $calendario = [];
    //                     if ( count($data) > 2 )
    //                     {
    //                           $pos1 = explode("/", $data[0]);
    //                           $pos3 = explode("/", $data[count($data) - 1]);
    //
    //                           $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]] ];
    //                           $calendario[] = 'A';
    //                           $calendario[] = [ 'dia' => $pos3[0], 'mes' => $nomeMeses[$pos3[1]] ];
    //                     }
    //                     elseif ( count($data) > 1 )
    //                     {
    //                           $pos1 = explode("/", $data[0]);
    //                           $pos3 = explode("/", $data[count($data) - 1]);
    //
    //                           $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]] ];
    //                           $calendario[] = 'E';
    //                           $calendario[] = [ 'dia' => $pos3[0], 'mes' => $nomeMeses[$pos3[1]] ];
    //                     }
    //                     else
    //                     {
    //                           $pos1 = explode("/", $data[0]);
    //                           $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]] ];
    //                     }
    //
    //                     $item->calendario = $calendario;
    //               }
    //
    //           }
    //     }
    //
    //     return $listAll;
    // }

    public function siteMeses()
    {
        $meses = new Programacao();
        $arrayMeses = [];
        $nomeMeses = ['01' => 'JANEIRO', '02' => 'FEVEREIRO', '03' => 'MARÇO', '04' => 'ABRIL', '05' => 'MAIO', '06' => 'JUNHO', '07' => 'JULHO', '08' => 'AGOSTO', '09' => 'SETEMBRO', '10' => 'OUTUBRO', '11' => 'NOVEMBRO', '12' => 'DEZEMBRO'];
        $mesesReturn = [];
        $mesesAll = $meses->all();

        foreach ($mesesAll as $key => $value)
        {
            $array = json_decode($value->data);
            for ($i=0; $i< count($array); $i++)
            {
              $datetime = new DateTime();
              $data = $datetime->createFromFormat('d/m/Y', trim($array[$i]));

              if (!in_array($data->format('m'), $arrayMeses))
              {
                  $arrayMeses[] = $data->format('m');
              }

              foreach($arrayMeses as $item)
              {
                  $mesesReturn[intval($item)] = ['nome' => $nomeMeses[$item], 'numero' => $item];
              }

            }
        }

        ksort($mesesReturn);
        return $mesesReturn;
    }


    public function siteEvento($id)
    {
        $list = DB::table('programacoes')->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal')
                                         ->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal')
                                         ->leftjoin('programacao_has_categoria', 'programacao_has_categoria.id_programacao', '=', 'programacoes.id')
                                         ->leftjoin('programacao_has_local', 'programacao_has_local.id_programacao', '=', 'programacoes.id')
                                         ->leftjoin('casas', 'casas.id', '=', 'programacao_has_local.id_local')
                                         ->leftjoin('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                         ->where('programacoes.id', $id);

        $listAll = $list->addSelect('programacoes.*',
                                    'programacoes.id as id',

                                    'categorias.color as categoria_color',
                                    'categorias.name as categoria_name',
                                    'categorias.namefilefull as categoria_namefilefull',

                                    'casas.id as casa_id',
                                    'casas.name as casa_name',
                                    'casas.endereco as casa_endereco',
                                    'casas.numero as casa_numero',
                                    'casas.cep as casa_cep',
                                    'casas.localizacao as casa_localizacao',
                                    'casas.cidade as casa_cidade',
                                    'casas.telefone as casa_telefone',
                                    'casas.celular as casa_celular',

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


          $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];
          foreach($listAll as $item)
          {

              // Retorna todas categorias vinculadas
              $list = DB::table('programacao_has_categoria')
                                ->join('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                ->where('programacao_has_categoria.id_programacao', $item->id);

              $item->categorias = $list->addSelect('categorias.*')->get();

              // tratamento para o banner e calendario
              $data = json_decode($item->data);
              $item->dataArray = $data;
              $calendario = [];
              $listDatas = [];
              $listHours = [];

              if (count($data))
              {
                    // Trata calendario do banner
                    if ( count($data) > 2 )
                    {
                          $pos1 = explode("/", $data[0]);
                          $pos3 = explode("/", $data[count($data) - 1]);

                          $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]], 'ano' => $pos1[2] ];
                          $calendario[] = 'A';
                          $calendario[] = [ 'dia' => $pos3[0], 'mes' => $nomeMeses[$pos3[1]], 'ano' => $pos3[2] ];
                    }
                    elseif ( count($data) > 1 )
                    {
                          $pos1 = explode("/", $data[0]);
                          $pos3 = explode("/", $data[count($data) - 1]);

                          $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]], 'ano' => $pos1[2] ];
                          $calendario[] = 'E';
                          $calendario[] = [ 'dia' => $pos3[0], 'mes' => $nomeMeses[$pos3[1]], 'ano' => $pos3[2] ];
                    }
                    else
                    {
                          $pos1 = explode("/", $data[0]);
                          $calendario[] = [ 'dia' => $pos1[0], 'mes' => $nomeMeses[$pos1[1]], 'ano' => $pos1[2] ];
                    }

                    $item->calendario = $calendario;

                    // Trata datas e horas do evento
                    $horarios = explode(",", $item->horario);
                    for ($i=0; $i < count($horarios); $i++)
                    {
                        $listHours[] = explode('|', $horarios[$i]);
                    }
                    $item->listHours = $listHours;
              }

          }

          return $listAll->toArray()[0];
    }

    public function siteEventoGaleria($id)
    {
        $list = DB::table('galerias_has_files-galeria')->join('files-galeria', 'files-galeria.id', '=', 'galerias_has_files-galeria.id_file')
                                         ->where('galerias_has_files-galeria.id_programacao', $id);

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


    public function siteEventos($params = [])
    {
        // Valor negativo retorna todos
        $limit = $params['limit'] ?? -1;
        $PesquisaRelacionada = [];
        if (isset($params['PesquisaRelacionada'])) {
            $PesquisaRelacionada = $params['PesquisaRelacionada'];
        }

        // Lista Relacionada
        $list = DB::table('programacoes');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal');
        // $list->leftjoin('programacao_has_categoria', 'programacao_has_categoria.id_programacao', '=', 'programacoes.id')
        // $list->leftjoin('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
        if (count($PesquisaRelacionada)) {
            $list->join('programacao_has_local as PL', 'PL.id_programacao', '=', 'programacoes.id');
            $list->where('PL.id_local', '=', $PesquisaRelacionada['id']);
        }
        $list->where('programacoes.data_final', '>=', NOW());
        $list->limit($limit);
        $list->orderBy('programacoes.created_at', 'desc');



        $listAll = $list->addSelect('programacoes.*',
                                    'programacoes.id as id',
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
                    $list = DB::table('programacao_has_categoria')
                                      ->join('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                      ->where('programacao_has_categoria.id_programacao', $item->id);

                    $item->categorias = $list->addSelect('categorias.*')->get();
              }
         }

         return $listAll;
    }


    public function listProgramacoes()
    {
        $list = DB::table('programacoes')->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal')
                                  ->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal')
                                   ->orderBy('programacoes.created_at', 'desc');

        $listAll = $list->addSelect('programacoes.*',
                                    'programacoes.id as id',

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
        $list = DB::table('programacoes')->join('files', 'files.id', '=', 'programacoes.banner_principal')
                                  ->where('programacoes.id', $id);

        $return = $list->addSelect('programacoes.*',
                                    'programacoes.id as id',

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
        $list = DB::table('programacoes')->join('files', 'files.id', '=', 'programacoes.imagem_principal')
                                  ->where('programacoes.id', $id);

        $return = $list->addSelect('programacoes.*',
                                    'programacoes.id as id',

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



    /* ====================================================================== */
    // AJAX
    /* ====================================================================== */
    public function siteEventosAjax($params)
    {
        $dataAtual = new DateTime();
        $arrayDatas = [];

        $list = DB::table('programacoes');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal');

        // Trata pesquisa search
        if ( $params['search'] != '' )
        {
            $list->where('programacoes.name', 'like', '%'.$params['search'].'%');
            $list->orWhere('programacoes.sub_title', 'like', '%'.$params['search'].'%');
            $list->orWhere('programacoes.texto_evento', 'like', '%'.$params['search'].'%');
            $list->orWhere('programacoes.servico', 'like', '%'.$params['search'].'%');
            $list->orWhere('programacoes.ingressos', 'like', '%'.$params['search'].'%');
        }

        // Trata filtro Meses
        if ( count($params['mes']) > 0 )
        {
            for($i=0; $i < count($params['mes']); $i++)
            {
                if ($i == 0) {
                    $list->where('programacoes.data', 'like', '%\/'.$params['mes'][$i].'%');
                } else {
                    $list->orWhere('programacoes.data', 'like', '%\/'.$params['mes'][$i].'%');
                }
            }
        }

        // Trata filtro dias
        if ( count($params['dia']) > 0 )
        {
            for($i=0; $i < count($params['dia']); $i++)
            {
                $searchDias = DB::table('programacoes');
                $listDiasArray = $searchDias->where( 'programacoes.data', 'like', '%"'.$params['dia'][$i].'%' )
                                            ->where( 'programacoes.data_final', '>=', date('y/m/d') );

                foreach ($listDiasArray->get()->toArray() as $item)
                {
                    if ( !in_array($item->id, $arrayDatas) ) {
                        $arrayDatas[] = $item->id;
                    }
                }
            }

            $list->whereIn('programacoes.id', $arrayDatas);
        }

        // Trata filtro categorias
        if ( count($params['cat']) > 0 )
        {
            $list->leftjoin('programacao_has_categoria', 'programacao_has_categoria.id_programacao', '=', 'programacoes.id');
            $list->whereIn('programacao_has_categoria.id_categoria', $params['cat']);
        }

        // Pesquisa Relacionada
        if ( count($params['PesquisaRelacionada']) )
        {
            switch ($params['PesquisaRelacionada']['tabela']) {
                case 'Casas':
                    $list->join('programacao_has_local', 'programacao_has_local.id_programacao', '=', 'programacoes.id');
                    $list->where('programacao_has_local.id_local', '=', $params['PesquisaRelacionada']['id']);
                    break;
            }
        }

        $list->where('programacoes.data_final', '>=', date('y/m/d') );
        $list->orderBy('programacoes.data_inicial', 'asc');

        $listAll = $list->addSelect('programacoes.*',
                                    'programacoes.id as id',

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
                                    );
         // $listAll = $listAll->get();
         // return $listAll;


         $listAll2 = $listAll;
         $listAll = $listAll->skip($params['paginacao'])->take($params['NRegistros'])->get();
         $nextRegister = $listAll2->skip($params['paginacao'] + $params['NRegistros'])->take(1)->get();

         if ($listAll->count())
         {
              $nomeDias = [ 'Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb' ];
              $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];

              foreach($listAll as $item)
              {
                    $list = DB::table('programacao_has_categoria')
                                      ->join('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                      ->where('programacao_has_categoria.id_programacao', $item->id);

                    $item->nameLink = str_slug($item->name, '-');
                    $item->categorias = $list->addSelect('categorias.*')->get();
                    $item->paginacao = $params['paginacao'];
                    $item->nextRegister = count($nextRegister) ? true : false;

                    $calendario = json_decode($item->data);

                    // Trata calendario
                    $item->calendario = null;
                    if (count($calendario))
                    {
                        $pos = explode("/", $calendario[0]);
                        $data = new DateTime($pos[2].$pos[1].$pos[0]);

                        $item->calendario = [ ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ] ];

                        if (count($calendario) > 1)
                        {
                            if (count($calendario) == 2) {
                                $item->calendario[] = 'E';
                            } else {
                                $item->calendario[] = 'A';
                            }

                            $pos = explode("/", $calendario[count($calendario) - 1]);
                            $data = new DateTime($pos[2].$pos[1].$pos[0]);
                            $item->calendario[] = ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ];
                        }
                    }
              }
         }

         return $listAll;
    }

    public function siteLugaresAjax($params)
    {
        $dataAtual = new DateTime();

        $list = DB::table('casas');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal');

        // Trata pesquisa search
        if ( $params['search'] != '' )
        {
            $list->where('casas.name', 'like', '%'.$params['search'].'%');
            $list->orWhere('casas.sub_title', 'like', '%'.$params['search'].'%');
            $list->orWhere('casas.endereco', 'like', '%'.$params['search'].'%');
            $list->orWhere('casas.cidade', 'like', '%'.$params['search'].'%');
            $list->orWhere('casas.responsavel', 'like', '%'.$params['search'].'%');
        }

        // Trata filtro categorias
        if ( count($params['cat']) > 0 )
        {
            $list->leftjoin('casa_has_categoria', 'casa_has_categoria.id_casa', '=', 'casas.id');
            $list->whereIn('casa_has_categoria.id_categoria', $params['cat']);
        }

        $list->orderBy('casas.created_at', 'desc');

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
                                    );
         // $listAll = $listAll->get();
         // return $listAll;

         $listAll2 = $listAll;
         $listAll = $listAll->skip($params['paginacao'])->take($params['NRegistros'])->get();
         $nextRegister = $listAll2->skip($params['paginacao'] + $params['NRegistros'])->take(1)->get();

         if ($listAll->count())
         {
              foreach($listAll as $item)
              {
                    $list = DB::table('casa_has_categoria')
                                      ->join('categorias', 'categorias.id', '=', 'casa_has_categoria.id_categoria')
                                      ->where('casa_has_categoria.id_casa', $item->id);

                    $item->nameLink = str_slug($item->name, '-');
                    $item->categorias = $list->addSelect('categorias.*')->get();
                    $item->paginacao = $params['paginacao'];
                    $item->nextRegister = count($nextRegister) ? true : false;
              }
         }

         return $listAll;
    }

    public function siteConteudoAjax($params)
    {
        $dataAtual = new DateTime();

        $list = DB::table('noticias');
        $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'noticias.banner_principal');
        $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'noticias.imagem_principal');

        // Trata pesquisa search
        if ( $params['search'] != '' )
        {
            $list->where('noticias.name', 'like', '%'.$params['search'].'%');
            $list->orWhere('noticias.sub_title', 'like', '%'.$params['search'].'%');
            $list->orWhere('noticias.texto', 'like', '%'.$params['search'].'%');
            $list->orWhere('noticias.texto2', 'like', '%'.$params['search'].'%');
        }

        // Trata filtro categorias
        if ( count($params['cat']) > 0 )
        {
            $list->leftjoin('noticia_has_categoria', 'noticia_has_categoria.id_noticia', '=', 'noticias.id');
            $list->whereIn('noticia_has_categoria.id_categoria', $params['cat']);
        }

        $list->orderBy('noticias.created_at', 'desc');

        $listAll = $list->addSelect('noticias.*',
                                    'noticias.id as id',

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
                                    );
         // $listAll = $listAll->get();

         $listAll2 = $listAll;
         $listAll = $listAll->skip($params['paginacao'])->take($params['NRegistros'])->get();
         $nextRegister = $listAll2->skip($params['paginacao'] + $params['NRegistros'])->take(1)->get();

         if ($listAll->count())
         {
              foreach($listAll as $item)
              {
                    $list = DB::table('noticia_has_categoria')
                                      ->join('categorias', 'categorias.id', '=', 'noticia_has_categoria.id_categoria')
                                      ->where('noticia_has_categoria.id_noticia', $item->id);

                    $item->nameLink = str_slug($item->name, '-');
                    $item->categorias = $list->addSelect('categorias.*')->get();
                    $item->paginacao = $params['paginacao'];
                    $item->nextRegister = count($nextRegister) ? true : false;
              }
         }

         return $listAll;
    }

    public function siteRegisterNewsletterAjax($request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $whatsapp = $request->input('whatsapp');
        $categorias = $request->input('categorias');
        if ($categorias) {
           $categorias = json_encode( $categorias, true );
        }

        $newLetter = new Newsletter();
        $newLetter->name = $name;
        $newLetter->email = $email;
        $newLetter->whatsapp = $whatsapp;
        $newLetter->categorias = $categorias;

        $newLetter->save();
        return json_encode( true );
    }

    public function siteBannersTopsAjax($request)
    {
        $id = $request->id;
        $ativo = $request->ativo;
        $table = $request->table;
        $column = $request->column;

        DB::table($table)
            ->where('id', $id)
            ->update([$column => $ativo]);

        return  ['id' => $id, 'table' => $table, 'column' => $column];
        // return  $id;
    }

    public function siteOrderBannersTopsAjax($request)
    {
        $id = $request->id;
        $table = $request->table;
        $column = $request->column;
        $value = $request->value;

        DB::table($table)
            ->where('id', $id)
            ->update([$column => $value]);

        return  ['id' => $id, 'table' => $table, 'column' => $column, 'value' => $value];
    }



    /* ====================================================================== */
    // Filtros Meses e dias
    /* ====================================================================== */
    public function filtrosMesesDias()
    {
        $return = [ 'meses' => [], 'dias' => [] ];


        // Gera os meses
        $nomeMeses = ['01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'];
        $meses = [];

        for ($i=0; $i < 12; $i++)
        {
            $data = new DateTime();
            $data->add(new DateInterval('P'.$i.'M'));

            if (!in_array($data->format('m'), $nomeMeses))
            {
                $meses[] = [ 'numero'    => $data->format('m'),
                             'nome'      => $nomeMeses[$data->format('m')],
                             'dataAsc'   => $data->format('d/m/Y'),
                             'dataAsc2'  => $data->format('d-m-Y'),
                             'dataAsc3'  => $data->format('dmY'),
                             'dataDesc'  => $data->format('Y/m/d'),
                             'dataDesc2' => $data->format('Y-m-d'),
                             'dataDesc3' => $data->format('Ymd')
                           ];
            }
        }
        $return['meses'] = $meses;


        // Gera os dias
        $nomeDias = [ 'Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb' ];
        $dias  = [];

        for ($i=0; $i < 30; $i++)
        {
            $data = new DateTime();
            $data->add(new DateInterval('P'.$i.'D'));

            if (!in_array($data->format('D'), $nomeDias))
            {
                $dias[] = [ 'numero'    => $data->format('d'),
                            'nome'      => $nomeDias[$data->format('D')],
                            'dataMes'   => $data->format('m'),
                            'dataAsc'   => $data->format('d/m/Y'),
                            'dataAsc2'  => $data->format('d-m-Y'),
                            'dataAsc3'  => $data->format('dmY'),
                            'dataDesc'  => $data->format('Y/m/d'),
                            'dataDesc2' => $data->format('Y-m-d'),
                            'dataDesc3' => $data->format('Ymd')
                          ];
            }
        }
        $return['dias'] = $dias;

        return $return;
    }



    function pesquisa($section, $pesquisa)
    {
        // Eventos
        if ($section == 'eventos')
        {
            $list = DB::table('programacoes');
            $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'programacoes.banner_principal');
            $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'programacoes.imagem_principal');

            // Trata pesquisa search
            if ( $pesquisa != '' )
            {
                $list->where('programacoes.name', 'like', '%'.$pesquisa.'%');
                $list->orWhere('programacoes.sub_title', 'like', '%'.$pesquisa.'%');
                $list->orWhere('programacoes.texto_evento', 'like', '%'.$pesquisa.'%');
                $list->orWhere('programacoes.servico', 'like', '%'.$pesquisa.'%');
                $list->orWhere('programacoes.ingressos', 'like', '%'.$pesquisa.'%');
            }

            $list->where('programacoes.data_final', '>=', date('y/m/d') );
            $list->orderBy('programacoes.data_inicial', 'asc');

            $listAll = $list->addSelect('programacoes.*',
                                        'programacoes.id as id',

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
                 $nomeDias = [ 'Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb' ];
                 $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];

                 foreach($listAll as $item)
                 {
                       $list = DB::table('programacao_has_categoria')
                                         ->join('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                         ->where('programacao_has_categoria.id_programacao', $item->id);

                       $item->nameLink = str_slug($item->name, '-');
                       $item->categorias = $list->addSelect('categorias.*')->get();

                       $calendario = json_decode($item->data);

                       // Trata calendario
                       $item->calendario = null;
                       if (count($calendario))
                       {
                           $pos = explode("/", $calendario[0]);
                           $data = new DateTime($pos[2].$pos[1].$pos[0]);

                           $item->calendario = [ ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ] ];

                           if (count($calendario) > 1)
                           {
                               if (count($calendario) == 2) {
                                   $item->calendario[] = 'E';
                               } else {
                                   $item->calendario[] = 'A';
                               }

                               $pos = explode("/", $calendario[count($calendario) - 1]);
                               $data = new DateTime($pos[2].$pos[1].$pos[0]);
                               $item->calendario[] = ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ];
                           }
                       }
                 }
            }

            return $listAll->toArray();
        }


        // Conteudos
        if ($section == 'conteudos')
        {
            $dataAtual = new DateTime();

            $list = DB::table('noticias');
            $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'noticias.banner_principal');
            $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'noticias.imagem_principal');

            // Trata pesquisa search
            if ( $pesquisa != '' )
            {
                $list->where('noticias.name', 'like', '%'.$pesquisa.'%');
                $list->orWhere('noticias.sub_title', 'like', '%'.$pesquisa.'%');
                $list->orWhere('noticias.texto', 'like', '%'.$pesquisa.'%');
                $list->orWhere('noticias.texto2', 'like', '%'.$pesquisa.'%');
            }

            $list->orderBy('noticias.created_at', 'desc');

            $listAll = $list->addSelect('noticias.*',
                                        'noticias.id as id',

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
                        $list = DB::table('noticia_has_categoria')
                                          ->join('categorias', 'categorias.id', '=', 'noticia_has_categoria.id_categoria')
                                          ->where('noticia_has_categoria.id_noticia', $item->id);

                        $item->nameLink = str_slug($item->name, '-');
                        $item->categorias = $list->addSelect('categorias.*')->get();
                  }
             }

             return $listAll->toArray();
        }

        // Lugares
        if ($section == 'lugares')
        {

          $dataAtual = new DateTime();

          $list = DB::table('casas');
          $list->leftjoin('files as banner_principal', 'banner_principal.id', '=', 'casas.banner_principal');
          $list->leftjoin('files as imagem_principal', 'imagem_principal.id', '=', 'casas.imagem_principal');

          // Trata pesquisa search
          if ( $pesquisa != '' )
          {
              $list->where('casas.name', 'like', '%'.$pesquisa.'%');
              $list->orWhere('casas.sub_title', 'like', '%'.$pesquisa.'%');
              $list->orWhere('casas.endereco', 'like', '%'.$pesquisa.'%');
              $list->orWhere('casas.cidade', 'like', '%'.$pesquisa.'%');
              $list->orWhere('casas.responsavel', 'like', '%'.$pesquisa.'%');
          }

          $list->orderBy('casas.created_at', 'desc');

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

           if ($listAll->count())
           {
                foreach($listAll as $item)
                {
                      $list = DB::table('casa_has_categoria')
                                        ->join('categorias', 'categorias.id', '=', 'casa_has_categoria.id_categoria')
                                        ->where('casa_has_categoria.id_casa', $item->id);

                      $item->nameLink = str_slug($item->name, '-');
                      $item->categorias = $list->addSelect('categorias.*')->get();
                }
           }

           return $listAll->toArray();

        }

    }
}
