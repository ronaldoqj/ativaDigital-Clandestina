<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class NoticiasHasCategoria extends Model
{
    protected $table = 'noticia_has_categoria';
}
