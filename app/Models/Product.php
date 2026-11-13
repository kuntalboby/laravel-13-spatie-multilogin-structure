<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    //
    protected $guarded = [];
   protected static function booted(): void
   {
      static::creating(function (Product $product) {
         $product->randomid = Str::random(20);
         $product->user_id = Auth::id();
      });

      static::saving(function (Product $product) {
         if ($product->isDirty(['name', 'brand_id'])) {
               $product->slug = static::generateUniqueSlug($product);
         }
       });

      static::addGlobalScope('is_deleted', function (Builder $builder) {
         $builder->where('is_deleted', '0');
      });
   }

     public function brand(){
        return $this->belongsTo(Brand::class);
     }
     public function gender(){
        return $this->belongsTo(Gender::class);
     }
     public function category(){
        return $this->belongsTo(Category::class);
     }
      public function productPrices(){
        return $this->hasMany(ProductPrice::class);
     }
     public function galleries(){
      return $this->hasMany(ProductGallery::class)->orderBy('sorting_order');
    }
   //   public function brandSizes(){
   //      return $this->hasMany(BrandSize::class);
   //   }


      protected static function generateUniqueSlug(Product $product): string{
         $brandName = $product->brand?->name.' '.$product->name;
         $baseSlug = $brandName ? Str::slug($brandName) : 'miscellaneous'.'-'.Str::slug($product->name);
         $slug = $brandName.'-'.$baseSlug;
         $count = 1;

         if ($product->isDirty('brand_id')) {
            $product->load('brand');
         }

        

         while (static::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $brandPart = $brandName ? Str::slug($brandName) : 'miscellaneous';
            $slug = $brandPart . $baseSlug.'-'. $count++;
         }

         return $slug;
}


}
