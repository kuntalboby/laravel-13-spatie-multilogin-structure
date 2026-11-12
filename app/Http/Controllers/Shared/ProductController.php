<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductInfoRequest;
use App\Models\Brand;
use App\Models\BrandSize;
use App\Models\Category;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\ImageManager;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ProductController extends Controller
{
    //
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Product::with(['brand:id,name', 'category:id,name'])
            ->where('products.is_deleted', '0')
            ->select(['products.name','products.category_id','products.brand_id',
                'products.status','products.randomid','products.image','products.form_step_counter']);

        return DataTables::eloquent($query)
            ->filter(function ($q) use ($request) {
                if ($search = trim($request->input('search.value', ''))) {
                    $q->where(function ($w) use ($search) {
                        $w->where('products.name', 'like', "%{$search}%")
                          ->orWhere('products.short_description', 'like', "%{$search}%")
                          ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$search}%"))
                          ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$search}%"));
                    });
                }
            }, true)
            ->orderColumn('brand', function ($q, $order) {
                $q->orderBy(
                    Brand::select('name')->whereColumn('brands.id', 'products.brand_id'),
                    $order
                );
            })
            ->orderColumn('category', function ($q, $order) {
                $q->orderBy(
                    Category::select('name')->whereColumn('categories.id', 'products.category_id'),
                    $order
                );
            })
            ->addColumn('image', function ($p) {
                $src = $p->image
                    ? asset('storage/products/thumbs/' . $p->image)
                    : asset('storage/icons/noimg.png');
                return '<img src="' . e($src) . '" alt="" width="50" height="50"
                             style="object-fit:cover;border-radius:6px;">';
            })
            ->addColumn('brand', fn ($p) => e($p->brand->name ?? '-'))
            ->addColumn('category', fn ($p) => e($p->category->name ?? '-'))
            ->addColumn('status', function ($p) {
                    $formStepStatus =  $p->form_step_counter < config('PROD_FORMS_COUNT') ? 'info' : 'check';
                    $formStepStatusColor =  $p->form_step_counter < config('PROD_FORMS_COUNT') ? 'warning' : 'success';
                    $statusInfo =  $p->form_step_counter < config('PROD_FORMS_COUNT') ? 'Draft' : 'Completed';
                return $p->status == 1
                    ? '<span class="text text-'.$formStepStatusColor.'" title="'.$statusInfo.'"><i class="fas fa-'.$formStepStatus.'"></i></span>'
                    : 'span class="text text-danger"><i class="fas fa-times"></i></span>';
            })
            ->addColumn('action', function ($p) {
                $edit = route('admin.masters.products.edit', $p->randomid);
                $view = route('admin.masters.products.view', $p->randomid);

                // $del  = route('admin.masters.products.destroy', $p->randomid);
                return '
                    <a href="' . $view . '" class="mr-3" title="View Product">
                        <i class="fas fa-book-reader text-warning"></i>
                    </a>
                    <a href="' . $edit . '" class="" title="Edit Product">
                        <i class="fas fa-pen text-info"></i>
                    </a>
                    
                    ';
                    ';
                    
                    // <button type="button" class=""
                    //         data-url="' . $del . '">
                    //     <i class="fas fa-trash text-danger"></i>
                    // </button>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->toJson();
    }

        return view('admin.products.index');


    }

    public function create(){
        $allCategories = Category::whereDoesntHave('children')->select(['id','name'])->get();
        $allBrands = Brand::all();
        $genders = Gender::all();

        $formSteps = [1=>'Basic',2=>'Variations',3=>'Gallery'];

        return view('admin.products.create', compact('allBrands', 'allCategories','genders','formSteps'));

    }


    public function viewProduct(string $slug){
        $productInfo = Product::where('randomid', $slug)->with(
            [
                'category:id,name',
                'brand:id,name',
                'gender:id,name',
                'gender:id,name',
                'galleries:product_id,id,file_name,file_type',
                'productPrices',
                'productPrices.brandSize:id,size,size_chart,product_type',
                'productPrices.color:id,name,color_code'
            ]
        )->firstOrFail();

        // return $productInfo;
        return view('admin.products.view', compact('productInfo'));

    }

    public function storeProduct( ProductInfoRequest $request){
        $validated = $request->validated();
        $imageName = null;
        // return $validated;
            try {
                $form_step_counter = 1; // basic info form
                
                
                    if ($request->hasFile('image')) {
                            $file     = $request->file('image');
                            $filename = $file->hashName();

                            $file->storeAs('products', $filename, 'public');

                            $manager = new ImageManager(new Driver()); // GD, which you already enabled

                            $thumb = $manager->read($file)->cover(
                                (int) config('app.prod_image_thumb_w', 300),
                                (int) config('app.prod_image_thumb_h', 300)
                            );

                            Storage::disk('public')->put(
                                'products/thumbs/' . $filename,
                                (string) $thumb->toJpeg(80)
                            );

                            $imageName = $filename;
                        }

            $product = Product::create([
                'name'              => $validated['name'],
                'gst'               => $validated['gst'],
                'category_id'       => $validated['category_id'],
                'brand_id'          => $validated['brand_id'],
                'gender_id'         => $validated['gender_id'],
                'product_for'       => $validated['product_for'],
                'short_description' => $validated['short_description'] ?? null,
                'long_description'  => $validated['long_description'] ?? null,
                'related_product_hash_tag'  => $validated['related_product_hash_tag'] ?? null,
                'is_featured'       => $validated['is_featured'] ? '1' : '0',
                'is_promotional'    => $validated['is_promotional'] ? '1' : '0',
                'status'            => $validated['status'] ? '1' : '0',

                'image'             => $imageName,
                'form_step_counter' =>$form_step_counter
            ]);

            session()->flash('response', 'success');
            return redirect()->back()
                ->with('message', 'Basic information of the product created successfully.')
                ->with('product_id', $product->id)
                ->with('next_step', 2);
                        
                    } catch (\Throwable $th) {

                    // remove image if any error comes

                    if ($imageName) {
                            Storage::disk('public')->delete([
                                'products/' . $imageName,
                                'products/thumbs/' . $imageName,
                            ]);
                        }
                        session()->flash('response','danger');
                        return redirect()->back()
                            ->withInput()
                            ->with('message', $th->getMessage())
                            ->with('next_step', 2);
                    }    

    }

    public function basicUpdate( ProductInfoRequest $request , string $slug){
        $prodImage = Product::where('randomid', $slug)->pluck('image')->first();
        // return $prod->get('image');
        $validated = $request->validated();
        $imageName =$prodImage;
        //    return $prodImage;
            try {               
                
                    if ($request->hasFile('image')) {
                            $file     = $request->file('image');
                            $filename = $file->hashName();

                            $file->storeAs('products', $filename, 'public');

                            $manager = new ImageManager(new Driver()); // GD, which you already enabled

                            $thumb = $manager->read($file)->cover(
                                (int) config('app.prod_image_thumb_w', 300),
                                (int) config('app.prod_image_thumb_h', 300)
                            );

                            Storage::disk('public')->put(
                                'products/thumbs/' . $filename,
                                (string) $thumb->toJpeg(80)
                            );

                            $imageName = $filename;
                            if($prodImage){
                                Storage::disk('public')->delete([
                                    'products/' . $prodImage,
                                    'products/thumbs/' .$prodImage,
                                ]);
                            }
                            
                        }

            Product::where('randomid',$slug)->update([
                'name'              => $validated['name'],
                'gst'               => $validated['gst'],
                // 'category_id'       => $validated['category_id'],
                // 'brand_id'          => $validated['brand_id'],
                // 'gender_id'         => $validated['gender_id'],
                // 'product_for'       => $validated['product_for'],
                'short_description' => $validated['short_description'] ?? null,
                'long_description'  => $validated['long_description'] ?? null,
                'related_product_hash_tag'  => $validated['related_product_hash_tag'] ?? null,
                'is_featured'       => $validated['is_featured'] ? '1' : '0',
                'is_promotional'    => $validated['is_promotional'] ? '1' : '0',
                'status'            => $validated['status'] ? '1' : '0',
                'image'             => $imageName,
            ]);

            session()->flash('response', 'success');
            return redirect()->back()
                ->with('message', 'Basic information of the product updated successfully.')
                ->with('next_step', 2);
                        
                    } catch (\Throwable $th) {

                    // remove image if any error comes

                        if ($imageName) {
                            // Storage::disk('public')->delete([
                            //     'products/' . $imageName,
                            //     'products/thumbs/' . $imageName,
                            // ]);
                        }
                        session()->flash('response','danger');
                        return redirect()->back()
                            ->withInput()
                            ->with('message', $th->getMessage())
                            ->with('next_step', 2);
                    }    

    }

    public function editProduct(string $slug){
        $allCategories = Category::whereDoesntHave('children')->select(['id','name'])->get();
        $allBrands = Brand::all();
        $genders = Gender::all();
        $colors = Color::all();

        $product = Product::with('brand:id,name')->with('productPrices')
            ->with([
                'productPrices.brandSize:id,size',
                'productPrices.color:id,name,color_code',
                ])->with('category:id,name')
                ->where('randomid',$slug)
                ->firstOrFail();

        // return $product;
        $allSizes = BrandSize::where([
            'brand_id' => $product->brand_id,
            'category_id' => $product->category_id,
            'gender_id' => $product->gender_id,
            'size_of'=>$product->product_for
        ])->orderBy('id')->select(['product_type','size','size_chart','id'])->get();            
                    // return $allSizes;

        $productColors = $product->productPrices
                ->unique('color_id')          // one price row per color
                ->pluck('color')              // its color model (id, name) from the eager load
                ->filter()
                ->values();
                // return $productColors; 
         
                    
        $formSteps = [1=>'Basic',2=>'Variations',3=>'Gallery'];

        return view('admin.products.edit', compact('allBrands', 'colors','allCategories','genders','formSteps','product','allSizes','productColors'));

    }

    public function  actionVariation(Request $request, string $randomid){
        $product   = Product::where('randomid', $randomid)->firstOrFail();
        $now       = now();
        $rows      = [];
        $validated = $request->validate([
            'data'                       => ['required', 'array', 'min:1'],
            'data.*.quantity'            => ['required', 'integer', 'min:0'],
            'data.*.original_quantity'   => ['required', 'integer', 'min:0'],
            'data.*.buying_price'        => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
            'data.*.sku'                 => ['nullable'],
            'data.*.actual_price'        => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
            'data.*.discount_percentage' => ['nullable', 'numeric', 'between:0,100'],
            'data.*.status'              => ['nullable', 'in:1'],
        ], [
            'data.required' => 'Add at least one color and size combination.',
        ]);

        foreach ($validated['data'] as $key => $item) {
        [$colorId, $brandSizeId] = explode('_', $key, 2);

        $buyingPrice   = round((float) $item['buying_price'], 2);
        $actual   = round((float) $item['actual_price'], 2);
        $discount = round((float) ($item['discount_percentage'] ?? 0), 2);

        $selling_price_with_discount  = $actual * (100-$discount)/100;
        $selling_price_with_gst = $actual * $product->gst / 100;
        $selling_price = $selling_price_with_discount + $selling_price_with_gst;

        $rows[$key] = [
            'product_id'       => $product->id,
            'brand_size_id'    => (int) $brandSizeId,
            'color_id'         => (int) $colorId,
            'entered'          => (int) $item['quantity'],   
            'original'         => (int) $item['original_quantity'],
            'buying_price'     => $buyingPrice,
            'sku'              => $item['sku'],
            'discount_percentage' => $discount,
            'mrp_price'        => $actual,
            'selling_price'    => $selling_price,
            'status'           => isset($item['status']) ? '1' : '0',
        ];
    }
    // return $rows;
       try {
            DB::transaction(function () use ($rows, $product) {
                
            // lock all rows 
            $existing = ProductPrice::where('product_id', $product->id)
                ->lockForUpdate()
                ->get()
                ->keyBy(fn ($p) => $p->color_id . '_' . $p->brand_size_id);

            foreach ($rows as $key => $r) {
                $row = $existing->get($key);

                $values = [
                    'buying_price'        => $r['buying_price'],
                    'sku'                 => $r['sku'],
                    'mrp_price'           => $r['mrp_price'],
                    'discount_percentage' => $r['discount_percentage'],
                    'selling_price'       => $r['selling_price'],
                    'status'              => $r['status'],
                ];

                if ($row) {
                    $delta  = $r['entered'] - $r['original'];   // 7 - 10 = -3
                    $newQty = $row->quantity + $delta;          // 9 + (-3) = 6, read after the lock

                    if ($newQty < 0) {
                        throw ValidationException::withMessages([
                            "data.$key.quantity" => "Stock changed while you were editing. "
                                . "Current stock is {$row->quantity}, so a change of {$delta} is not possible.",
                        ]);
                    }

                    $row->update($values + ['quantity' => $newQty]);
                } else {
                    // new combination: the entered quantity is the opening stock
                    ProductPrice::create($values + [
                        'product_id'    => $r['product_id'],
                        'color_id'      => $r['color_id'],
                        'brand_size_id' => $r['brand_size_id'],
                        'quantity'      => $r['entered'],
                    ]);
                }
            }

            // rows the admin removed from the page
            collect(array_diff_key($existing->all(), $rows))->each->delete();
            Product::whereKey($product->id)->update(['form_step_counter' => 2]);
        });

        return redirect()->back()
            ->with('response', 'success')
            ->with('message', count($rows) . ' price variation(s) saved successfully.');

    } catch (ValidationException $e) {
        throw $e;
    } catch (\Throwable $th) {
        return redirect()->back()
            ->withInput()
            ->with('response', 'danger')
            ->with('message', $th->getMessage());
    }

    }

    public function downloadAllVariationExcel(Request $request, string $randomid){
    $product = Product::where('randomid', $randomid)->firstOrFail();

    $data = $request->validate([
        'size_ids'    => ['required', 'array', 'min:1', 'max:50'],
        'size_ids.*'  => ['integer', 'distinct'],
        'color_ids'   => ['required', 'array', 'min:1', 'max:50'],
        'color_ids.*' => ['integer', 'distinct'],
    ], [
        'size_ids.required'  => 'Select at least one size.',
        'color_ids.required' => 'Select at least one color.',
    ]);

    // sizes must belong to this product's brand
    $sizes = BrandSize::where('brand_id', $product->brand_id)
        ->whereIn('id', $data['size_ids'])->orderBy('id')->get(['id', 'size']);
    $colors = Color::whereIn('id', $data['color_ids'])->orderBy('id')->get(['id', 'name']);

    if ($sizes->count() !== count($data['size_ids']) || $colors->count() !== count($data['color_ids'])) {
        return response()->json(['message' => 'Invalid size or color selected.'], 422);
    }
    if ($sizes->count() * $colors->count() > 1000) {
        return response()->json(['message' => 'Too many combinations. Select fewer sizes or colors.'], 422);
    }

    // existing rows, so a re-download is pre-filled
    $existingKeys = ProductPrice::where('product_id', $product->id)
    ->get(['color_id', 'brand_size_id'])
    ->map(fn ($p) => $p->color_id . '_' . $p->brand_size_id)
    ->all();

    $headers = [
        'product_id', 'size_id', 'color_id', 'product_name', 'size', 'color',
        'sku', 'quantity', 'buying_price', 'mrp', 'discount_percentage', 'available(Y/N)',
    ];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Variations');

    foreach ($headers as $i => $h) {
        $sheet->setCellValueExplicit([$i + 1, 1], $h, DataType::TYPE_STRING);
    }

    // reads a column only if the table has it (sku and buying_price may not exist yet)
    $attr = fn ($model, string $key) => $model ? ($model->getAttributes()[$key] ?? null) : null;

    $r = 2;
    foreach ($sizes as $size) {
        foreach ($colors as $color) {
            if (in_array($color->id . '_' . $size->id, $existingKeys, true)) continue;   // already exists, skip

            $sheet->setCellValueExplicit([1, $r], (string) $product->randomid, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit([2, $r], (string) $size->id, DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit([3, $r], (string) $color->id, DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit([4, $r], (string) $product->name, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit([5, $r], strtoupper($size->size), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit([6, $r], strtoupper($color->name), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit([12, $r], 'Y', DataType::TYPE_STRING);   // default available
            $r++;
        }
    }

    if ($r === 2) {
        return response()->json([
            'message' => 'All selected combinations already exist. Edit them in the form.',
        ], 422);
    }
    $last = $r - 1;

    // look and feel
    $sheet->getStyle('A1:L1')->getFont()->setBold(true);
    $sheet->getStyle('A1:L1')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFF3CD');
    $sheet->getStyle("A2:F{$last}")->getFill()->setFillType('solid')->getStartColor()->setRGB('F2F2F2'); // do not edit
    $sheet->getStyle("I2:J{$last}")->getNumberFormat()->setFormatCode('0.00');
    $sheet->freezePane('A2');
    foreach (range(1, count($headers)) as $i) {
        $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
    }

    // Y/N dropdown
    $dv = new DataValidation();
    $dv->setType(DataValidation::TYPE_LIST)
        ->setErrorStyle(DataValidation::STYLE_STOP)
        ->setAllowBlank(false)
        ->setShowDropDown(true)
        ->setShowErrorMessage(true)
        ->setErrorTitle('Invalid value')
        ->setError('Use Y or N.')
        ->setFormula1('"Y,N"');
    $sheet->setDataValidation("L2:L{$last}", $dv);

    $filename = 'variations_' . Str::slug($product->name) . '_' . now()->format('Ymd_His') . '.xlsx';

    return response()->streamDownload(function () use ($spreadsheet) {
        (new Xlsx($spreadsheet))->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}

// upload variation 
private function sellingPrice(Product $product, float $mrp, float $discount): float
{
    $afterDiscount = $mrp * (100 - $discount) / 100;
    return round($afterDiscount * (1 + ((float) $product->gst) / 100), 2);
}

public function uploadVariationExcel(Request $request, string $randomid)
{
    $product = Product::where('randomid', $randomid)->firstOrFail();

    $request->validate([
        'excel_file' => ['required', 'file', 'mimes:xlsx', 'max:2048'],
    ], [
        'excel_file.mimes' => 'Please upload an .xlsx file.',
        'excel_file.max'   => 'File must be 2 MB or smaller.',
    ]);

    /* ---------- read the file ---------- */
    try {
        $all = IOFactory::load($request->file('excel_file')->getRealPath())
            ->getActiveSheet()->toArray(null, true, false, false);
    } catch (\Throwable $e) {
        return response()->json(['message' => 'Could not read the Excel file.Err:'.$e->getMessage()], 422);
    }

    if (count($all) < 2)    return response()->json(['message' => 'The file has no data rows.'], 422);
    if (count($all) > 1001) return response()->json(['message' => 'Too many rows (max 1000).'], 422);

    $header   = array_map(fn ($h) => trim((string) $h), array_shift($all));
    $required = ['product_id', 'size_id', 'color_id', 'size', 'color', 'sku', 'quantity',
                 'buying_price', 'mrp', 'discount_percentage', 'available(Y/N)'];

    if ($missing = array_diff($required, $header)) {
        return response()->json([
            'message' => 'Invalid template. Missing: ' . implode(', ', $missing) . '. Please download a fresh file.',
        ], 422);
    }

    /* ---------- validate every row ---------- */
    $toInt  = fn ($v) => (is_numeric($v) && floor((float) $v) == (float) $v) ? (int) $v : null;
    $rows   = [];
    $errors = [];
    $line   = 1;

    foreach ($all as $raw) {
        $line++;
        if (!array_filter($raw, fn ($v) => trim((string) $v) !== '')) continue;   // blank row

        $d    = array_combine($header, array_slice(array_pad($raw, count($header), null), 0, count($header)));
        $cell = fn (string $n) => trim((string) ($d[$n] ?? ''));

        if ($cell('product_id') !== $product->randomid) {
            $errors[] = "Row $line: this file belongs to a different product.";
            continue;
        }

        $sizeId  = $toInt($cell('size_id'));
        $colorId = $toInt($cell('color_id'));
        if (!$sizeId || !$colorId) {
            $errors[] = "Row $line: invalid size_id or color_id.";
            continue;
        }

        $key = $colorId . '_' . $sizeId;
        if (isset($rows[$key])) {
            $errors[] = "Row $line: duplicate of row {$rows[$key]['line']}.";
            continue;
        }

        $qty  = $toInt($cell('quantity'));
        $buy  = $cell('buying_price');
        $mrp  = $cell('mrp');
        $disc = $cell('discount_percentage') === '' ? '0' : $cell('discount_percentage');
        $avl  = strtoupper($cell('available(Y/N)'));
        $sku  = $cell('sku');

        $bad = [];
        if ($qty === null || $qty < 0)                                $bad[] = 'quantity must be a whole number (0 or more)';
        if (!is_numeric($buy) || $buy <= 0 || $buy > 9999999999.99)   $bad[] = 'buying_price must be greater than 0';
        if (!is_numeric($mrp) || $mrp <= 0 || $mrp > 9999999999.99)   $bad[] = 'mrp must be greater than 0';
        if (!is_numeric($disc) || $disc < 0 || $disc > 100)           $bad[] = 'discount_percentage must be 0 to 100';
        if (!in_array($avl, ['Y', 'N'], true))                        $bad[] = 'available must be Y or N';
        if (mb_strlen($sku) > 100)                                    $bad[] = 'sku is too long (max 100)';

        if ($bad) {
            $errors[] = "Row $line: " . implode('; ', $bad) . '.';
            continue;
        }

        $mrpF  = round((float) $mrp, 2);
        $discF = round((float) $disc, 2);

        $rows[$key] = [
            'line'                => $line,
            'label'               => strtoupper($cell('color')) . ' / ' . strtoupper($cell('size')),
            'product_id'          => $product->id,
            'brand_size_id'       => $sizeId,
            'color_id'            => $colorId,
            'quantity'            => $qty,                      // opening stock
            'buying_price'        => round((float) $buy, 2),
            'sku'                 => $sku === '' ? null : $sku,
            'mrp_price'           => $mrpF,
            'discount_percentage' => $discF,
            'selling_price'       => $this->sellingPrice($product, $mrpF, $discF),
            'status'              => $avl === 'N' ? '1' : '0',  // 1 = not available
        ];
    }

    /* ---------- checks that need the database ---------- */
    if ($rows) {
        // sizes must belong to this product's brand, colors must exist
        $okSizes  = BrandSize::where('brand_id', $product->brand_id)
            ->whereIn('id', collect($rows)->pluck('brand_size_id')->unique())->pluck('id')->all();
        $okColors = Color::whereIn('id', collect($rows)->pluck('color_id')->unique())->pluck('id')->all();

        foreach ($rows as $r) {
            if (!in_array($r['brand_size_id'], $okSizes, true) || !in_array($r['color_id'], $okColors, true)) {
                $errors[] = "Row {$r['line']}: size or color does not belong to this product.";
            }
        }

        // the file may only ADD combinations; existing ones are edited in the form
        $existingKeys = ProductPrice::where('product_id', $product->id)
            ->get(['color_id', 'brand_size_id'])
            ->map(fn ($p) => $p->color_id . '_' . $p->brand_size_id)
            ->all();

        foreach ($rows as $key => $r) {
            if (in_array($key, $existingKeys, true)) {
                $errors[] = "Row {$r['line']}: {$r['label']} already exists. Edit it in the form.";
            }
        }

        // SKUs: unique inside the file and not used by any other variant
        // $skus = collect($rows)->pluck('sku')->filter();
        // foreach ($skus->duplicates()->unique() as $dup) {
        //     $errors[] = "SKU \"$dup\" appears more than once in the file.";
        // }
        // foreach (ProductPrice::whereIn('sku', $skus->unique()->values())->pluck('sku')->unique() as $used) {
        //     $errors[] = "SKU \"$used\" is already used by another variant.";
        // }
    }

    if ($errors) {
        return response()->json([
            'message' => 'The file has errors. Nothing was saved.',
            'errors'  => array_slice(array_unique($errors), 0, 20),
        ], 422);
    }
    if (!$rows) {
        return response()->json(['message' => 'No data rows found.'], 422);
    }

    /* ---------- save (all or nothing) ---------- */
    try {
        DB::transaction(function () use ($rows, $product) {
            foreach ($rows as $r) {
                ProductPrice::create([
                    'product_id'          => $r['product_id'],
                    'brand_size_id'       => $r['brand_size_id'],
                    'color_id'            => $r['color_id'],
                    'quantity'            => $r['quantity'],
                    'buying_price'        => $r['buying_price'],
                    'sku'                 => $r['sku'],
                    'mrp_price'           => $r['mrp_price'],
                    'discount_percentage' => $r['discount_percentage'],
                    'selling_price'       => $r['selling_price'],
                    'status'              => $r['status'],
                ]);
            }

            // move to the next step, but never move a product backwards
            Product::whereKey($product->id)->where('form_step_counter', '<', 2)
                ->update(['form_step_counter' => 2]);
        });
    } catch (\Illuminate\Database\QueryException $e) {
        // the unique index stopped a duplicate, e.g. two people uploading at once
        report($e);
        return response()->json(['message' => 'Some variations or SKUs already exist. Reload the page and try again.'], 422);
    } catch (\Throwable $th) {
        report($th);
        return response()->json(['message' => 'Could not save the variations.'], 500);
    }

    session()->flash('response', 'success');
    session()->flash('message', count($rows) . ' variation(s) added from Excel.');

    return response()->json(['message' => count($rows) . ' variation(s) added.']);
}



    public function uploadColorMedia(Request $request, string $randomid){
    $product = Product::where('randomid', $randomid)->firstOrFail();

    $request->validate([
        'color_id' => ['required', 'integer'],
        'file'     => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp,mp4,webm'],
    ], [
        'file.max'      => 'File must be 5 MB or smaller.',
        'file.mimes'    => 'Only jpg, png, webp, mp4 and webm files are allowed.',
        'file.uploaded' => 'Upload failed. The file may be larger than the server allows.',
    ]);

    // the color must have a price row for this product
    if (!$product->productPrices()->where('color_id', $request->color_id)->exists()) {
        return response()->json(['message' => 'Invalid color for this product.'], 422);
    }

    $file     = $request->file('file');
    $filename = $file->hashName();
    $isImage  = str_starts_with((string) $file->getMimeType(), 'image/');

    try {
        $file->storeAs('products/colors', $filename, 'public');

        if ($isImage) {
            $thumb = (new ImageManager(new Driver()))->read($file)->cover(
                (int) config('app.prod_image_thumb_w', 300),
                (int) config('app.prod_image_thumb_h', 300)
            );
            Storage::disk('public')->put(
                'products/colors/thumbs/' . $filename,
                (string) $thumb->toJpeg(80)
            );
        }

        $sort = (int) ProductGallery::where('product_id', $product->id)
            ->where('color_id', $request->color_id)
            ->max('sorting_order');

        $media = ProductGallery::create([
            'product_id'    => $product->id,
            'color_id'      => (int) $request->color_id,
            'file_name'     => $filename,
            'file_type'     => $isImage ? 'image' : 'video',
            'name'          => Str::limit($file->getClientOriginalName(), 250, ''),
            'sorting_order' => $sort + 1,
        ]);

        return response()->json([
            'randomid'   => $media->id,   // the JS reads this key; it holds the row id
            'type'       => $media->file_type,
            'url'        => asset('storage/products/colors/' . $filename),
            'thumb_url'  => asset('storage/products/colors/thumbs/' . $filename),
            'delete_url' => route('admin.masters.products.color-media.delete', [$product->randomid, $media->id]),
        ]);

    } catch (\Throwable $th) {
        // remove files that were written before the failure
        Storage::disk('public')->delete([
            'products/colors/' . $filename,
            'products/colors/thumbs/' . $filename,
        ]);

        report($th);
        return response()->json(['message' => 'Could not save the file.'], 500);
    }
}

/* ------------------------------------------------------------------ */
/*  Delete one file                                                    */
/* ------------------------------------------------------------------ */
public function deleteColorMedia(string $randomid, int $id)
{
    $product = Product::where('randomid', $randomid)->firstOrFail();

    // scoped to the product, so an id from another product can't be removed
    $media = ProductGallery::where('product_id', $product->id)
        ->where('id', $id)
        ->firstOrFail();

    $media->deleteFiles();
    $media->delete();

    return response()->json(['message' => 'Deleted.']);
}

public function sortColorMedia(Request $request, string $randomid)
{
    $product = Product::where('randomid', $randomid)->firstOrFail();

    $data = $request->validate([
        'color_id' => ['required', 'integer'],
        'ids'      => ['required', 'array', 'min:1'],
        'ids.*'    => ['integer', 'distinct'],
    ]);

    // every id must belong to this product and this color
    $valid = ProductGallery::where('product_id', $product->id)
        ->where('color_id', $data['color_id'])
        ->whereIn('id', $data['ids'])
        ->pluck('id')
        ->all();

    if (count($valid) !== count($data['ids'])) {
        return response()->json(['message' => 'Invalid items in the list.'], 422);
    }

    DB::transaction(function () use ($data) {
        foreach ($data['ids'] as $position => $id) {
            ProductGallery::where('id', $id)->update(['sorting_order' => $position + 1]);
        }
    });

    return response()->json(['message' => 'Order saved.']);
}

    public function destroy(string $randomid){
    $product = Product::where('randomid', $randomid)->firstOrFail();
    $product->update(['is_deleted' => '1']); // soft delete, matches your other tables

    return response()->json(['message' => 'Product deleted successfully.']);
}
}
