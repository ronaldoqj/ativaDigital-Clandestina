<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class ProgramacaoHasCategoria extends Model
{
    protected $table = 'programacao_has_categoria';
}
