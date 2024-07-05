<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\scopes\langScope;
class product_brand extends Model
{
    use HasFactory;
    protected $table='product_brand';
    protected $primaryKey ='id';
    public $timestamps = false;
  protected $guarded = [];
    //   protected static function booted()
    // {
    //     static::addGlobalScope(new LangScope);
    // }
}
