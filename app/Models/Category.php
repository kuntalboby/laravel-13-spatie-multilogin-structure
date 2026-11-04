<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected  $guarded = [];

    //
    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if ($category->isDirty('title')) {
                $category->slug = Str::slug($category->title,'-');
            }
            $category->randomid = Str::random(20);
        });
    }
    // public static function getParentTree($category) {
    //     $parents = [];
        
    //     while ($category->parent) { // Check if the category has a parent
    //         $category = $category->parent; // Move up the hierarchy
    //         $parents[] = [
    //             'id' => $category->id,
    //             'name' => $category->name,
    //             'slug' => $category->slug,
    //             'status'=>$category->status
    //         ];
    //     }
    //     return $parents;
    //     //return array_reverse($parents); // Ensure higher-level parents come first
    // }

    // public static function getCategoryTree($categories, $parentId = null, $prefix = '') {
    //     $tree = [];
    
    //     // Convert collection to an array if needed
    //     $categories = is_array($categories) ? $categories : $categories->toArray();
    
    //     foreach ($categories as $category) {
    //         if ($category['parent_id'] == $parentId) {
    //             $tree[] = [
    //                 'id' => $category['id'],
    //                 'name' => $prefix . $category['name'], // Add prefix for hierarchy
    //             ];
    
    //             // Recursively get children with indentation
    //             $children = self::getCategoryTree($categories, $category['id'], $prefix . '-- ');
    //             $tree = array_merge($tree, $children);
    //         }
    //     }
    
    //     return $tree;
    // }
}
