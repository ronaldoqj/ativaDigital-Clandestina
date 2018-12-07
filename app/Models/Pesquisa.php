<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Programacao;
use DB;

class Pesquisa extends Model
{
    public function pesquisa($pesquisa)
    {
        $return = [ 'pesquisa'  => $pesquisa,
                    'eventos'   => [],
                    'conteudos' => [],
                    'lugares'   => [] ];

        $programacao = new Programacao();

        $list = $programacao->pesquisa('eventos', $pesquisa);
        if ( count($list) ) {
           $return['eventos'] = $list;
        }

        $list = $programacao->pesquisa('conteudos', $pesquisa);
        if ( count($list) ) {
           $return['conteudos'] = $list;
        }

        $list = $programacao->pesquisa('lugares', $pesquisa);
        if ( count($list) ) {
           $return['lugares'] = $list;
        }

        return $return;
    }
}
