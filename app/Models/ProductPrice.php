<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    //
    protected $guarded = [];

    protected static function booted(): void
   {
      static::addGlobalScope('is_deleted', function (Builder $builder) {
         $builder->where('is_deleted', '0');
      });
   }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function brandSize(){
        return $this->belongsTo(BrandSize::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
}
