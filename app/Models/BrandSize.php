<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandSize extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'size_chart' => 'array',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
     public function category(){
        return $this->belongsTo(Category::class);
    }
    public function gender(){
        return $this->belongsTo(Gender::class,'gender_id','id');
    }

}
