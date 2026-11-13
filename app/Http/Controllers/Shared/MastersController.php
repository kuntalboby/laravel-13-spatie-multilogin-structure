<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandSize;
use App\Models\Category;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MastersController extends Controller
{
    
    public function categoryIndex()
    {
        Gate::authorize('category.view');
        $allcategory = Category::where('is_deleted', '0')->orderBy('name','asc')->get();

        return view('admin.masters.categories', compact('allcategory'));
        
    }

    
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
            $request->validate([
                    'name' => ['required', 'max:100', Rule::unique('categories')->ignore($category->id)],
                    'parent_id' => ['required','min:0'],
                    'description' => ['nullable','max:600'],
                ]);
             try {
                

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
    

    //size master
    
    public function sizeIndex()
    {
        Gate::authorize('size.view');
        $allsize = Size::where('is_deleted', '0')->orderBy('name','asc')->get();

        return view('admin.masters.size', compact('allsize'));
        
    }

    
    public function createSize()
    {
        Gate::authorize('product_sizes.add');
        $allsize = Size::where('is_deleted', '0')->orderBy('name','asc')->get();
        return view('admin.masters.add-size', compact('allsize'));
    }

     public function storeSize(Request $request)
    {
        //
         Gate::authorize('product_sizes.add');
            $request->validate([
                'name' => ['required', 'unique:sizes', 'max:100'],
                'target_age' => ['required', 'in:"A","K"'],
                'size_for' => ['required', 'in:"T","B","S"'],
            ]);
            try {

            // return $request;
                        Size::create([
                                'name'        => $request->name,
                                'target_age'        => $request->target_age,
                                'size_for'        => $request->size_for,
                                'slug'        => strtolower($request->name),
                                'user_id'      => Auth::id(),
                                'status'      => $request->has('status') ? '0' : '1',
                            ]);
                        session()->flash('response','success');
                        return redirect()->back()->with('message','Size created successfully.');
                } catch (\Throwable $th) {
                    session()->flash('response','danger');
                    return redirect()->back()->with('message',$th->getMessage());
                }
       
    }

    public function editSize(string $slug , Request $request)
    {
        $size = Size::where('randomid', $slug)->firstOrFail();
        // Gate::authorize('product_sizes.edit', $size);
        Gate::authorize('product_sizes.edit');
        // $allsize = Size::whereNot('randomid', $slug)->where('is_deleted','0')->get();
        // return $size;
        // return $request->method();
       if( $request->method() === 'PUT'){
             $request->validate([
                    'name' => ['required', 'max:20', Rule::unique('sizes')->ignore($size->id)],
                    'target_age' => ['required', 'in:"A","K"'],
                    'size_for' => ['required', 'in:"T","B","S"'],
                ]);
             try {
            
                    $updatedData = Size::where('randomid', $slug)->update(
                        [
                                'name'        => $request->name,
                                'target_age'        => $request->target_age,
                                'size_for'        => $request->size_for,
                                'slug'        => strtolower($request->name),
                                'description' => null,
                                'status'      => $request->has('status') ? '0' : '1',
                        ]);
                        session()->flash('response','success');
                        return redirect()->back()
                            ->with('message','Size updated successfully.');
             } catch (\Throwable $th) {
                //throw $th;
                session()->flash('response','danger');
                return redirect()->back()->with('message',$th->getMessage());
             }
        }

        return view('admin.masters.edit-size', compact('size'));
    }
    

    //end size master

    //color master
     public function colorIndex()
    {
         Gate::authorize('product_color.view');
        $allcolors = Color::where('is_deleted', '0')
            ->orderBy('name','asc')
            ->paginate(config('app.pagination_count'));

        return view('admin.masters.color', compact('allcolors'));
        
    }

    
    public function createColor()
    {
         Gate::authorize('product_color.add');
        $allcolor = Color::where('is_deleted', '0')->orderBy('name','asc')->get();
        return view('admin.masters.add-color', compact('allcolor'));
    }

     public function storeColor(Request $request)
    {
        //
         Gate::authorize('product_color.add');
            $request->validate([
                'name' => ['required', 'unique:colors', 'max:100'],
                'description' => ['nullable', 'max:255'],
                'status' => ['required'],
                'color_code' => ['required'],
            ]);
            try {

            // return $request;
                        Color::create([
                                'name'        => $request->name,
                                'slug'        => strtolower($request->name),
                                'description' => $request->description,
                                'user_id'      => Auth::id(),
                                'status'      => $request->has('status') ? '0' : '1',
                                'color_code'  => $request->color_code,
                            ]);
                        session()->flash('response','success');
                        return redirect()->back()->with('message','Color created successfully.');
                } catch (\Throwable $th) {
                    session()->flash('response','danger');
                    return redirect()->back()->with('message',$th->getMessage());
                }
       
    }

    public function editColor(string $slug , Request $request)
    {
        Gate::authorize('product_color.edit');
        $color = Color::where('randomid', $slug)->firstOrFail();
            // Gate::authorize('edit',$color);
       $allcolor = Color::whereNot('randomid', $slug)->where('is_deleted','0')->get();

        // return $request->method();
        if( $request->method() === 'PUT'){
             try {
                $request->validate([
                    'name' => ['required', 'max:20', Rule::unique('colors')->ignore($color->id)],
                    'color_code' => ['required'],
                ]);
                //  dd($request->all());

                
                   $updatedData = Color::where('randomid', $slug)->update(
                        [
                                'name'        => $request->name,
                                 'slug'        => strtolower($request->name),
                                'description' => $request->description,
                                'status'      => $request->has('status') ? '0' : '1',
                                'color_code'  => $request->color_code,
                        ]);
                        session()->flash('response','success');
                        return redirect()->back()
                            ->with('message','Color updated successfully.');
                
             } catch (\Throwable $th) {
                //throw $th;
                session()->flash('response','danger');
                return redirect()->back()->with('message',$th->getMessage());
             }
        }

        return view('admin.masters.edit-color', compact('color','allcolor'));
    }

    //brand master
    public function brandIndex()
    {
        Gate::authorize('product_brands.view'); // policy already defined in BrandPolicy check if want to make user basis checcking
        $allbrands = Brand::where('is_deleted', '0')
            ->orderBy('name','asc')
            ->paginate(config('app.pagination_count'));

        return view('admin.masters.brand', compact('allbrands'));
        
    }

    
    public function createBrand()
    {
        Gate::authorize('product_brands');
        $allbrands = Brand::where('is_deleted', '0')->orderBy('name','asc')->get();
        return view('admin.masters.add-brand', compact('allbrands'));
    }

     public function storeBrand(Request $request)
    {
        //
         Gate::authorize('product_brands.add');
            $request->validate([
                'name' => ['required', 'unique:brands', 'max:200'],
                'brand_code' => ['nullable', 'unique:brands', 'max:100'],
                'description' => ['nullable', 'max:255'],
                'status' => ['required'],
                'brand_logo' => [
                    'nullable', 
                    'image', 
                    'mimes:png,jpg,jpeg,webp,gif', 
                    'max:3072' // Limits size to 3MB (3072 KB)
                ],
            ]);
            try {
                
                    if ($request->hasFile('brand_logo')) {
                        $file = $request->file('brand_logo');
                        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('uploads/brands', $filename, 'public');
                        $request->merge(['brand_logo' => $filename]);
                    }

            // return $request;
                        Brand::create([
                                'name'        => $request->name,
                                'brand_code'  => $request->brand_code,
                                'slug'        => strtolower($request->name),
                                'description' => $request->description,
                                'user_id'      => Auth::id(),
                                'status'      => $request->has('status') ? '0' : '1',
                                'brand_logo'  => $request->brand_logo,
                            ]);
                        session()->flash('response','success');
                        return redirect()->back()->with('message','Brand created successfully.');
                } catch (\Throwable $th) {
                    session()->flash('response','danger');
                    return redirect()->back()->with('message',$th->getMessage());
                }
       
    }

    public function editBrand(string $slug , Request $request)
    {

        $brand = Brand::where('randomid', $slug)->firstOrFail();
        Gate::authorize('product_brands.edit'); // policy already defined in BrandPolicy check if want to make user basis checcking
        //  Gate::authorize('edit',$brand);
        $allbrands = Brand::whereNot('randomid', $slug)->where('is_deleted','0')->get();

        // return $request->method();
        if( $request->method() === 'PUT'){
             try {
                $request->validate([
                    'name' => ['required', 'max:200', Rule::unique('brands')->ignore($brand->id)],
                    'brand_code' => ['nullable', 'max:200', Rule::unique('brands')->ignore($brand->id)],
                    'description' => ['nullable', 'max:255'],
                    'status' => ['required'],
                    'brand_logo' => [
                            'nullable', 
                            'image', 
                            'mimes:png,jpg,jpeg,webp,gif', 
                            'max:3072' // Limits size to 3MB (3072 KB)
                        ],
                ]);
                if ($request->hasFile('brand_logo')) {
                        

                        $file = $request->file('brand_logo');
                        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('uploads/brands', $filename, 'public');
                        
                        if ($brand->brand_logo && Storage::disk('public')->exists('uploads/brands/' . $brand->brand_logo)) {
                            Storage::disk('public')->delete('uploads/brands/' . $brand->brand_logo);
                        }

                        $request->merge(['brand_logo' => $filename]);
                    } else {
                        // If no new image is uploaded, retain the old image name in the request
                        $request->merge(['brand_logo' => $brand->brand_logo]);
                    }

                    $updatedData = Brand::where('randomid', $slug)->update(
                        [
                                'name'        => $request->name,
                                'slug'        => strtolower($request->name),
                                'description' => $request->description,
                                'status'      => $request->has('status') ? '0' : '1',
                                'brand_code'  => $request->brand_code,
                                'brand_logo'  => $request->brand_logo,
                        ]);
                        session()->flash('response','success');
                        return redirect()->back()
                            ->with('message','Brand updated successfully.');
             } catch (\Throwable $th) {
                //throw $th;
                session()->flash('response','danger');
                return redirect()->back()->with('message',$th->getMessage());
             }
        }

        return view('admin.masters.edit-brand', compact('brand','allbrands'));
    }
    

    public function brandSizes(string $slug)
    {

        $brand = Brand::with('brandSizes')
        ->with(['brandSizes.category:id,randomid,name', 'brandSizes.gender:id,name'])
        ->where('randomid', $slug)->firstOrFail();

         $listOfSizes = $brand->brandSizes->groupBy('category.name');
        // Gate::authorize('product_brands.edit'); // policy already defined in BrandPolicy check if want to make user basis checcking
        //  Gate::authorize('edit',$brand);

         return view('admin.masters.brand-sizes', compact('brand','listOfSizes'));
    }

    public function createBrandSize(string $slug)
    {
        $brand = Brand::where('randomid', $slug)->firstOrFail();
        $allcategory = Category::where('is_deleted', '0')->orderBy('name','asc')->get();
        $genders = Gender::orderBy('id','asc')->get();
        return view('admin.masters.create-brand-size', compact('brand', 'allcategory', 'genders'));
    }

 // key => label. Each one becomes two columns: "<label> (in)" and "<label> (cm)"

private const FIXED_COLUMNS = [
    'product_type', 'brand_code', 'category_code',
    'Brand', 'Gender', 'Category', 'Size',
];

private const CHART_MAP = [
    'T' => [
        'Chest(inches|centimeters)'           => 'chest',
        'Across Shoulder(inches|centimeters)' => 'across_shoulder',
        'Sleeve Length(inches|centimeters)'   => 'sleeve_length',
        'Length(inches|centimeters)'          => 'length',
        'Waist(inches|centimeters)'           => 'waist',
    ],
    'B' => [
        'Waist(inches|centimeters)'  => 'waist',
        'Hip(inches|centimeters)'    => 'hip',
        'Thigh(inches|centimeters)'  => 'thigh',
        'Length(inches|centimeters)' => 'length',
    ],
    'S' => [
        'Length(inches|centimeters)' => 'length',
    ],
];
/* ------------------------------------------------------------------ */
/*  EXPORT                                                            */
/* ------------------------------------------------------------------ */
public function storeBrandSizeCsvExport(Request $request)
{
    $request->validate([
        'brand_slug'   => 'required',
        'target_age'   => 'required|in:A,K',
        'category_id'  => 'required',
        'gender_id'    => 'required',
        'product_type' => 'required|in:T,B,S',
    ]);

    $type = $request->product_type;

    $brand = Brand::select('id', 'name', 'randomid')
       ->where('randomid', $request->brand_slug)->firstOrFail();

    $category = Category::select('id', 'randomid', 'name')
        ->where('randomid', $request->category_id)->firstOrFail();

    $gender = Gender::select('id', 'name')->where('id', $request->gender_id)->firstOrFail();

    $sizes = Size::select('id', 'name')
        ->where('status','0')
        ->where('size_for', $type)
        ->where('target_age', $request->target_age)
        ->orderBy('id')->get();

    abort_if($sizes->isEmpty(), 422, 'No sizes found for this selection.');

    $measureCols = array_keys(self::CHART_MAP[$type]);
    $columns     = array_merge(self::FIXED_COLUMNS, $measureCols);
    $fixedCount  = count(self::FIXED_COLUMNS);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Sizes');

    // header
    foreach ($columns as $i => $name) {
        $sheet->setCellValueExplicit([$i + 1, 1], $name, DataType::TYPE_STRING);
    }

    // rows
    $r = 2;
    foreach ($sizes as $size) {
        $fixed = [
            $type, $brand->randomid, $category->randomid,
            $brand->name, $gender->name, $category->name, (string) $size->name,
        ];
        foreach ($fixed as $c => $value) {
            $sheet->setCellValueExplicit([$c + 1, $r], $value, DataType::TYPE_STRING);
        }
        $r++;
    }
    $lastRow = $r - 1;

    $lastCol      = Coordinate::stringFromColumnIndex(count($columns));
    $firstMeasure = Coordinate::stringFromColumnIndex($fixedCount + 1);

    // style
    $sheet->getStyle("A1:{$lastCol}1")->getFont()->setBold(true);
    $sheet->getStyle("A1:{$lastCol}1")->getFill()
        ->setFillType('solid')->getStartColor()->setRGB('FFF3CD');
    $sheet->freezePane('A2');
    foreach (range(1, count($columns)) as $i) {
        $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
    }

    // measurement cells: text format (so 27|44 is kept as typed) and unlocked
    $range = "{$firstMeasure}2:{$lastCol}{$lastRow}";
    $sheet->getStyle($range)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
    $sheet->getStyle($range)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

    // everything else is locked, so codes/names can't be edited by mistake
    $sheet->getProtection()->setSheet(true);

    $filename = 'brand_size_' . Str::slug($brand->name) . '_' . $type . '_' . now()->format('Ymd_His') . '.xlsx';

    return response()->streamDownload(function () use ($spreadsheet) {
        (new Xlsx($spreadsheet))->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}
/* ------------------------------------------------------------------ */
/*  IMPORT                                                            */
/* ------------------------------------------------------------------ */
public function uploadBrandSizes(Request $request, string $slug)
{
    $brand = Brand::where('randomid', $slug)->firstOrFail();

    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx|max:2048',
    ]);

    try {
        $this->processBrandSizesExcel($request->file('excel_file')->getRealPath(), $brand);

        session()->flash('response', 'success');
        return redirect()->back()->with('message', 'Brand sizes uploaded successfully.');
    } catch (\Throwable $th) {
        session()->flash('response', 'danger');
        return redirect()->back()->with('message', $th->getMessage());
    }
}

protected function processBrandSizesExcel(string $filePath, Brand $brand): void
{
    $all = IOFactory::load($filePath)->getActiveSheet()->toArray(null, true, false, false);

    if (count($all) < 2) {
        throw new \Exception('The Excel file has no data rows.');
    }

    $header = array_map(fn ($h) => trim((string) $h), array_shift($all));

    foreach (self::FIXED_COLUMNS as $required) {
        if (!in_array($required, $header, true)) {
            throw new \Exception("Invalid template: column \"$required\" is missing. Please download a fresh file.");
        }
    }

    $rows   = [];
    $errors = [];
    $line   = 1;

    foreach ($all as $row) {
        $line++;

        if (!array_filter($row, fn ($v) => trim((string) $v) !== '')) continue;

        $row  = array_slice(array_pad($row, count($header), null), 0, count($header));
        $data = array_combine($header, $row);

        $type = strtoupper(trim((string) $data['product_type']));
        if (!isset(self::CHART_MAP[$type])) {
            $errors[] = "Row $line: invalid product_type.";
            continue;
        }

        if (trim((string) $data['brand_code']) !== $brand->randomid) {
            $errors[] = "Row $line: this file belongs to a different brand.";
            continue;
        }

        $categoryId = Category::where('randomid', trim((string) $data['category_code']))->value('id');
        $genderId   = Gender::where('name', trim((string) $data['Gender']))->value('id');
        $size       = trim((string) $data['Size']);

        if (!$categoryId) $errors[] = "Row $line: category not found.";
        if (!$genderId)   $errors[] = "Row $line: gender not found.";
        if ($size === '') $errors[] = "Row $line: size is empty.";

        // size_chart => {"length":"27|44", ...}
        $chart = [];
        foreach (self::CHART_MAP[$type] as $label => $key) {
            $value = str_replace(' ', '', trim((string) ($data[$label] ?? '')));
            if ($value === '') continue;

            if (!preg_match('/^\d+(\.\d+)?\|\d+(\.\d+)?$/', $value)) {
                $errors[] = "Row $line: $label must look like 27|44.";
                continue;
            }
            $chart[$key] = $value;
        }

        // if (!$chart) {
        //     $errors[] = "Row $line: no measurements filled.";
        // }

if (!$chart) continue; // if empty chart, skip this row but don't throw an error
        if ($categoryId && $genderId && $size !== '' && $chart) {
            $rows[] = [
                'keys' => [
                    'brand_id'     => $brand->id,
                    'category_id'  => $categoryId,
                    'gender_id'    => $genderId,
                    'product_type' => $type,
                    'size'         => $size,
                ],
                'chart' => $chart,
            ];
        }
    }

    if ($errors) {
        throw new \Exception(implode(' | ', array_slice($errors, 0, 5))
            . (count($errors) > 5 ? ' ... and ' . (count($errors) - 5) . ' more errors.' : ''));
    }

    DB::transaction(function () use ($rows) {
        foreach ($rows as $item) {
            $record = BrandSize::firstOrNew($item['keys']); //update if exists, else create newone
            if (!$record->exists) {
                $record->randomid = Str::random(15);
            }
            $record->size_chart = $item['chart'];
            $record->save();
        }
    });
}


    public function masterDelete(string $mode, string $slug)
    {
        if($mode === 'category'){

            try {

                 $category = Category::where('randomid', $slug);
                //  Gate::authorize('delete',$category->first());
                    Gate::authorize('category.delete'); 
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
