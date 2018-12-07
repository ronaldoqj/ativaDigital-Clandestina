<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Parceiro extends Model
{

    public function listParceiros()
    {
        $list = DB::table('parceiros')->leftjoin('files as image_logo', 'image_logo.id', '=', 'parceiros.image_logo')
                                       ->leftjoin('files as image_background', 'image_background.id', '=', 'parceiros.image_background')
                                       ->orderBy('parceiros.order', 'asc');

        $listAll = $list->addSelect('parceiros.*',
                                    'parceiros.id as id',

                                    'image_logo.id as image_logo_id',
                                    'image_logo.name as image_logo_name',
                                    'image_logo.description as image_logo_description',
                                    'image_logo.alternative_text as image_logo_alternative_text',
                                    'image_logo.path as image_logo_path',
                                    'image_logo.namefile as image_logo_namefile',
                                    'image_logo.namefilefull as image_logo_namefilefull',
                                    'image_logo.paththumb as image_logo_paththumb',
                                    'image_logo.namefilethumb as image_logo_namefilethumb',
                                    'image_logo.namefilefullthumb as image_logo_namefilefullthumb',

                                    'image_background.id as image_background_id',
                                    'image_background.name as image_background_name',
                                    'image_background.description as image_background_description',
                                    'image_background.alternative_text as image_background_alternative_text',
                                    'image_background.path as image_background_path',
                                    'image_background.namefile as image_background_namefile',
                                    'image_background.namefilefull as image_background_namefilefull',
                                    'image_background.paththumb as image_background_paththumb',
                                    'image_background.namefilethumb as image_background_namefilethumb',
                                    'image_background.namefilefullthumb as image_background_namefilefullthumb'
                                    )->get();
         return $listAll;
    }

    public function returnaImageLogo($id)
    {
        $list = DB::table('parceiros')->join('files', 'files.id', '=', 'parceiros.image_logo')
                                  ->where('parceiros.id', $id);

        $return = $list->addSelect('parceiros.*',
                                    'parceiros.id as id',

                                    'files.id as image_logo_id',
                                    'files.name as image_logo_name',
                                    'files.description as image_logo_description',
                                    'files.alternative_text as image_logo_alternative_text',
                                    'files.path as image_logo_path',
                                    'files.namefile as image_logo_namefile',
                                    'files.namefilefull as image_logo_namefilefull',
                                    'files.paththumb as image_logo_paththumb',
                                    'files.namefilethumb as image_logo_namefilethumb',
                                    'files.namefilefullthumb as image_logo_namefilefullthumb')->get();
         return $return;
    }
    public function returnaImageBackground($id)
    {
        $list = DB::table('parceiros')->join('files', 'files.id', '=', 'parceiros.image_background')
                                      ->where('parceiros.id', $id);

        $return = $list->addSelect('parceiros.*',
                                    'parceiros.id as id',

                                    'files.id as image_background_id',
                                    'files.name as image_background_name',
                                    'files.description as image_background_description',
                                    'files.alternative_text as image_background_alternative_text',
                                    'files.path as image_background_path',
                                    'files.namefile as image_background_namefile',
                                    'files.namefilefull as image_background_namefilefull',
                                    'files.paththumb as image_background_paththumb',
                                    'files.namefilethumb as image_background_namefilethumb',
                                    'files.namefilefullthumb as image_background_namefilefullthumb')->get();
         return $return;
    }
}
