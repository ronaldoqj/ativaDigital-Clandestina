<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class CasasHasCategoria extends Model
{
    protected $table = 'casa_has_categoria';
}
