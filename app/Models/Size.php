<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Size extends Model
{
    //
    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (Size $size) {
            $size->randomid = Str::random(20);
        });
        static::saving(function (Size $size) {
            if ($size->isDirty('name')) {
                $size->slug = Str::slug($size->name,'-');
            }
        });

        static::addGlobalScope('is_deleted', function (Builder $builder) {
         $builder->where('is_deleted', '0');
        });
    }

}
