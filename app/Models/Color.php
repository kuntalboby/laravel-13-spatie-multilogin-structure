<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Color extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('is_deleted', function (Builder $builder) {
            $builder->where('is_deleted', '0');
        });

        static::creating(function (Color $color) {
            $color->randomid = Str::random(20);
        });
        static::saving(function (Color $color) {
            if ($color->isDirty('name')) {
                $color->slug = Str::slug($color->name,'-');
            }
            
        });
    }
}
