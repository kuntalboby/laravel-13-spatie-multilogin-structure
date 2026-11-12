<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    //
    protected  $guarded = [];

    //
    protected static function booted(): void
    {
        static::addGlobalScope('is_deleted', function (Builder $builder) {
            $builder->where('is_deleted', '0');
        });

         static::creating(function (Brand $brand) {
            $brand->randomid = Str::random(20);
        });
        static::saving(function (Brand $brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = Str::slug($brand->name,'-');
            }
        });
    }

    public function brandSizes()
    {
        return $this->hasMany(BrandSize::class);
    }
}
