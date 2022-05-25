<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $id)
 * @method static where(string $string, string $string1, int $id)
 */
class Category extends Model
{
    protected $table = 'categories';

    public $primaryKey = 'id';

    use HasFactory;

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
