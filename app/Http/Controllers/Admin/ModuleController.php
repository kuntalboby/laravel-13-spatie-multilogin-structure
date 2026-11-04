<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class ModuleController extends Controller
{
    public function create()
    {
        return view('admin.modules.create');
    }
    public function index(){
    $modules = Module::latest()->get();

        return view('admin.modules.index', compact('modules'));
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:50'],
            'actions' => ['required', 'string'],
        ]);

        $slug = Str::slug($data['name'], '_');

        $actions = collect(explode(',', $data['actions']))
            ->map(fn ($a) => Str::slug(trim($a), '_'))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $module = Module::create([
            'name'    => $data['name'],
            'slug'    => $slug,
            'actions' => $actions,
        ]);

        foreach ($actions as $action) {
            Permission::firstOrCreate([
                'name'       => $slug . '.' . $action,
                'guard_name' => 'web',
            ]);
        }

        return back()->with('message', 'Module created.');
    }

    public function destroy(Module $module){
        foreach ($module->actions as $action) {
            Permission::where('name', $module->slug . '.' . $action)->delete();
        }

        $module->delete();

        return back()->with('success', 'Module deleted successfully.');
    }
}