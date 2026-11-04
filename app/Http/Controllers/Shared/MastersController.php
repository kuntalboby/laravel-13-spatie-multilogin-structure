<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MastersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function categoryIndex()
    {
        Gate::authorize('category.view');
        $allcategory = Category::where('is_deleted', '0')->orderBy('name','asc')->get();

        return view('admin.masters.categories', compact('allcategory'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createCategory()
    {
        Gate::authorize('category.add');
        $allcategory = Category::where('is_deleted', '0')->orderBy('name','asc')->get();
        return view('admin.masters.add-category', compact('allcategory'));
    }

    public function editCategory(string $slug , Request $request)
    {
        $category = Category::where('randomid', $slug)->firstOrFail();
        Gate::authorize('edit',$category);
        $allcategory = Category::whereNot('randomid', $slug)->where('is_deleted','0')->get();

        // return $request->method();
        if( $request->method() === 'PUT'){
             try {
                $request->validate([
                    'name' => ['required', 'max:100', Rule::unique('categories')->ignore($category->id)],
                    'parent_id' => ['required','min:0'],
                    'description' => ['nullable','max:600'],
                ]);

                    $updatedData = Category::where('randomid', $slug)->update(
                        [
                                'name'        => $request->name,
                                'slug'        => strtolower($request->name),
                                'parent_id'   => (int) $request->parent_id,
                                'description' => $request->description,
                                'featured'    => $request->has('featured') ? '0' : '1', 
                                'status'      => $request->has('status') ? '0' : '1',
                        ]);
                        session()->flash('response','success');
                        return redirect()->back()
                            ->with('message','Category updated successfully.');
             } catch (\Throwable $th) {
                //throw $th;
                session()->flash('response','danger');
                return redirect()->back()->with('message',$th->getMessage());
             }
        }

        return view('admin.masters.edit-category', compact('category','allcategory'));
    }
    public function masterDelete(string $mode, string $slug)
    {
        if($mode === 'category'){

            try {

                 $category = Category::where('randomid', $slug);
                 Gate::authorize('delete',$category->first());
                if($category->count('id')){
                
                    // $id = $category->pluck('id');
                    // Category::where('parent_id', $id)->update(['is_deleted','1']); //childs
                    $category->update(['is_deleted' => '1']);

                    session()->flash('response','success');
                    return redirect()->route('admin.masters.category')
                        ->with('message','Category deleted successfully.');
                }

                                // products also be deleted after this.
            } catch (\Throwable $th) {
                 session()->flash('response','danger');
                 return redirect()->back()->with('message',$th->getMessage());
            }
        }
            
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCategory(Request $request)
    {
        //
         Gate::authorize('category.add');
            $request->validate([
                'name' => ['required', 'unique:categories', 'max:100'],
                'parent_id' => ['required','min:0'],
                'description' => ['nullable','max:600'],
            ]);
            try {

            // return $request;
                        Category::create([
                                'name'        => $request->name,
                                'slug'        => strtolower($request->name),
                                'user_id'      => Auth::id(),
                                'parent_id'   => (int) $request->parent_id,
                                'description' => $request->description,
                                'featured'    => $request->has('featured') ? '0' : '1', 
                                'status'      => $request->has('status') ? '0' : '1',
                            ]);
                        session()->flash('response','success');
                        return redirect()->back()->with('message','Category created successfully.');
                } catch (\Throwable $th) {
                    session()->flash('response','danger');
                    return redirect()->back()->with('message',$th->getMessage());
                }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
