<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class GaleriaHasFileGaleria extends Model
{
    protected $table = 'galerias_has_files-galeria';



    public function listGaleriaADM ($id, $coluna = 'galerias_has_files-galeria.id_casa') {
       $list = DB::table('galerias_has_files-galeria')->join('files-galeria', 'files-galeria.id', '=', 'galerias_has_files-galeria.id_file')
                                                      ->where($coluna, $id)
                                                      ->orderBy('order');

      $listAll = $list->addSelect('files-galeria.id as id',
                                  'files-galeria.name as name',
                                  'files-galeria.description as description',
                                  'files-galeria.alternative_text as alternative_text',
                                  'files-galeria.path as path',
                                  'files-galeria.namefile as namefile',
                                  'files-galeria.namefilefull as namefilefull',

                                  'files-galeria.paththumb as paththumb',
                                  'files-galeria.namefilethumb as namefilethumb',
                                  'files-galeria.namefilefullthumb as namefilefullthumb',

                                  'files-galeria.created_at as created_at',
                                  'files-galeria.updated_at as img_updated_at')->get();
                                  //'categorias.nome as category_name')->get()->toArray();
       return $listAll;
    }
}
