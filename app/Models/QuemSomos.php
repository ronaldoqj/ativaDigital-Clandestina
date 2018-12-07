<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class QuemSomos extends Model
{
    protected $table = 'quem_somos';
    // =========================================================================
    // ADM
    // =========================================================================
    public function listQuemSomos()
    {
        $list = DB::table('quem_somos')->leftjoin('files as image_width', 'image_width.id', '=', 'quem_somos.image_width')
                                       ->leftjoin('files as image_height', 'image_height.id', '=', 'quem_somos.image_height')
                                       ->orderBy('quem_somos.order', 'asc');

        $listAll = $list->addSelect('quem_somos.*',
                                    'quem_somos.id as id',

                                    'image_width.id as image_width_id',
                                    'image_width.name as image_width_name',
                                    'image_width.description as image_width_description',
                                    'image_width.alternative_text as image_width_alternative_text',
                                    'image_width.path as image_width_path',
                                    'image_width.namefile as image_width_namefile',
                                    'image_width.namefilefull as image_width_namefilefull',
                                    'image_width.paththumb as image_width_paththumb',
                                    'image_width.namefilethumb as image_width_namefilethumb',
                                    'image_width.namefilefullthumb as image_width_namefilefullthumb',

                                    'image_height.id as image_height_id',
                                    'image_height.name as image_height_name',
                                    'image_height.description as image_height_description',
                                    'image_height.alternative_text as image_height_alternative_text',
                                    'image_height.path as image_height_path',
                                    'image_height.namefile as image_height_namefile',
                                    'image_height.namefilefull as image_height_namefilefull',
                                    'image_height.paththumb as image_height_paththumb',
                                    'image_height.namefilethumb as image_height_namefilethumb',
                                    'image_height.namefilefullthumb as image_height_namefilefullthumb'
                                    )->get();
         return $listAll;
    }

    public function returnaImageWidth($id)
    {
        $list = DB::table('quem_somos')->join('files', 'files.id', '=', 'quem_somos.image_width')
                                  ->where('quem_somos.id', $id);

        $return = $list->addSelect('quem_somos.*',
                                    'quem_somos.id as id',

                                    'files.id as image_width_id',
                                    'files.name as image_width_name',
                                    'files.description as image_width_description',
                                    'files.alternative_text as image_width_alternative_text',
                                    'files.path as image_width_path',
                                    'files.namefile as image_width_namefile',
                                    'files.namefilefull as image_width_namefilefull',
                                    'files.paththumb as image_width_paththumb',
                                    'files.namefilethumb as image_width_namefilethumb',
                                    'files.namefilefullthumb as image_width_namefilefullthumb')->get();
         return $return;
    }
    public function returnaImageHeight($id)
    {
        $list = DB::table('quem_somos')->join('files', 'files.id', '=', 'quem_somos.image_height')
                                  ->where('quem_somos.id', $id);

        $return = $list->addSelect('quem_somos.*',
                                    'quem_somos.id as id',

                                    'files.id as image_height_id',
                                    'files.name as image_height_name',
                                    'files.description as image_height_description',
                                    'files.alternative_text as image_height_alternative_text',
                                    'files.path as image_height_path',
                                    'files.namefile as image_height_namefile',
                                    'files.namefilefull as image_height_namefilefull',
                                    'files.paththumb as image_height_paththumb',
                                    'files.namefilethumb as image_height_namefilethumb',
                                    'files.namefilefullthumb as image_height_namefilefullthumb')->get();
         return $return;
    }



    // =========================================================================
    // site
    // =========================================================================
    public function Site_listQuemSomos()
    {
        $list = DB::table('quem_somos')->leftjoin('files as image_width', 'image_width.id', '=', 'quem_somos.image_width')
                                       ->leftjoin('files as image_height', 'image_height.id', '=', 'quem_somos.image_height')
                                       ->where('quem_somos.curador', '<>', 'S')
                                       ->orderBy('quem_somos.order', 'asc');

        $listAll = $list->addSelect('quem_somos.*',
                                    'quem_somos.id as id',

                                    'image_width.id as image_width_id',
                                    'image_width.name as image_width_name',
                                    'image_width.description as image_width_description',
                                    'image_width.alternative_text as image_width_alternative_text',
                                    'image_width.path as image_width_path',
                                    'image_width.namefile as image_width_namefile',
                                    'image_width.namefilefull as image_width_namefilefull',
                                    'image_width.paththumb as image_width_paththumb',
                                    'image_width.namefilethumb as image_width_namefilethumb',
                                    'image_width.namefilefullthumb as image_width_namefilefullthumb',

                                    'image_height.id as image_height_id',
                                    'image_height.name as image_height_name',
                                    'image_height.description as image_height_description',
                                    'image_height.alternative_text as image_height_alternative_text',
                                    'image_height.path as image_height_path',
                                    'image_height.namefile as image_height_namefile',
                                    'image_height.namefilefull as image_height_namefilefull',
                                    'image_height.paththumb as image_height_paththumb',
                                    'image_height.namefilethumb as image_height_namefilethumb',
                                    'image_height.namefilefullthumb as image_height_namefilefullthumb'
                                    )->get();
         return $listAll;
    }


    public function Site_listCuradores()
    {
        $list = DB::table('quem_somos')->leftjoin('files as image_width', 'image_width.id', '=', 'quem_somos.image_width')
                                       ->leftjoin('files as image_height', 'image_height.id', '=', 'quem_somos.image_height')
                                       ->where('quem_somos.curador', 'S')
                                       ->orderBy('quem_somos.order', 'asc');

        $listAll = $list->addSelect('quem_somos.*',
                                    'quem_somos.id as id',

                                    'image_width.id as image_width_id',
                                    'image_width.name as image_width_name',
                                    'image_width.description as image_width_description',
                                    'image_width.alternative_text as image_width_alternative_text',
                                    'image_width.path as image_width_path',
                                    'image_width.namefile as image_width_namefile',
                                    'image_width.namefilefull as image_width_namefilefull',
                                    'image_width.paththumb as image_width_paththumb',
                                    'image_width.namefilethumb as image_width_namefilethumb',
                                    'image_width.namefilefullthumb as image_width_namefilefullthumb',

                                    'image_height.id as image_height_id',
                                    'image_height.name as image_height_name',
                                    'image_height.description as image_height_description',
                                    'image_height.alternative_text as image_height_alternative_text',
                                    'image_height.path as image_height_path',
                                    'image_height.namefile as image_height_namefile',
                                    'image_height.namefilefull as image_height_namefilefull',
                                    'image_height.paththumb as image_height_paththumb',
                                    'image_height.namefilethumb as image_height_namefilethumb',
                                    'image_height.namefilefullthumb as image_height_namefilefullthumb'
                                    )->get();
         return $listAll;
    }

}
