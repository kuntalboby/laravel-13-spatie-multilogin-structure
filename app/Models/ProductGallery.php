<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductGallery extends Model
{
    //
    protected $guarded = [];
public function deleteFiles(): void
    {
        Storage::disk('public')->delete([
            'products/colors/' . $this->file_name,
            'products/colors/thumbs/' . $this->file_name,   // videos have no thumb, delete() ignores it
        ]);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
}
