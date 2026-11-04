<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         Gate::authorize('manager.view');
         $users = User::role('manager')->get();
         return view('admin.manager.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          Gate::authorize('manager.create');
          $gender = ['M' => 'Male', 'F' => 'Female', 'T' => 'Transgender'];
          $status = [0 => 'Active', 1 => 'Pending', 2=>'Suspended',4=>'Inactive'];
          return view('admin.manager.create',compact('gender','status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('manager.create');
         $request->validate([
                    'email' => ['email','required','max:100'],
                    'first_name' => ['required','min:2','max:100'],
                    'last_name' => ['required','min:2','max:100'],
                    'password' => ['required', 'confirmed','min:6'],
                ]);
          try {
                $user = User::create([
                    'first_name'    => $request->first_name,
                    'last_name'    => $request->last_name,
                    'gender'    => $request->gender,
                    'email'    => $request->email,
                    'status'    => $request->status,
                    'password' => Hash::make($request->password),
                ]);
                 $user->assignRole('manager');
                 session()->flash('response','success');
                        return redirect()->back()
                            ->with('message','Manager created successfully.'); 
          } catch (\Throwable $th) {
            report($th);
            session()->flash('response','danger');
                        return redirect()->back()
                            ->with('message','Manager has not been created.');
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
    public function edit(string $slug , Request $request)
    {
        $user = User::where('randomid',$slug)->firstOrFail();
        Gate::authorize('viewAndUpdate', $user);
        try {
         if ($request->method() === 'PUT') {
                      
                $request->validate([
                    'email' => ['email','required','max:100', Rule::unique('users')->ignore($user->id)],
                    'first_name' => ['required','min:2','max:100'],
                    'last_name' => ['required','min:2','max:100'],
                ]);

                    $updatedData = User::where('randomid', $slug)->update(
                        [
                                'email'        => $request->email,
                                'first_name'   => $request->first_name,
                                'last_name' => $request->last_name,
                                'gender'    => $request->gender,
                                'status'      => $request->has('status') ? $request->status : '1',
                        ]);
                        session()->flash('response','success');
                        return redirect()->back()
                            ->with('message','Manager updated successfully.');
             

            }

             $gender = ['M' => 'Male', 'F' => 'Female', 'T' => 'Transgender'];
             $status = [0 => 'Active', 1 => 'Pending', 2=>'Suspended',4=>'Inactive'];
        //   Gate::authorize('manager.view');
          
            
          
          return view('admin.manager.edit',compact('user','gender','status'));

           


        } catch (\Throwable $th) {
            report($th); 
               session()->flash('response','danger');
                return redirect()->back()->with('message',$th->getMessage());

        }
         
        
    }

    public function updatePassword(string $slug , Request $request)
    {

        // return $request;
         $user = User::where('randomid', $slug)->first();
         Gate::authorize('viewAndUpdate', $user);
        try {
         

            if ($request->method() === 'PUT') {
            $user = User::where('randomid', $slug)->first();

            if (!$user) {
                session()->flash('response', 'danger');
                return redirect()->back()->with('message', 'User not found!');
            }

                // 2. Validate using a custom closure for the specific user's password
                $request->validate([
                    'current_password' => [
                        'required',
                        function ($attribute, $value, $fail) use ($user) {
                            if (!Hash::check($value, $user->password)) {
                                $fail('The current password doesn\'t match.');
                            }
                        },
                    ],
                    'password' => ['required', 'confirmed', Password::defaults()],
                ]);

                // 3. Perform the update
                $update = $user->update([
                    'password' => Hash::make($request->password),
                ]);

                if ($update) {
                    session()->flash('response', 'success');
                    return redirect()->back()->with('message', 'Profile password has been updated successfully');
                }

                    session()->flash('response', 'danger');
                    return redirect()->back()->withInput()->with('message', 'Failed to update password. Please try again.');

                } else {
                    session()->flash('response', 'danger');
                    return redirect()->back()->with('message', 'Unauthorized access!');
                }

        } catch (\Throwable $th) {
               report($th); 
               session()->flash('response','danger');
                return redirect()->back()->with('message',$th->getMessage());

        }
         
        
    }
    


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('manager.delete');
        try {
             $update = User::where('randomid',$id)->update([
                    'is_deleted' => '1'
                ]);

                if ($update) {
                    session()->flash('response', 'success');
                    return redirect()->back()->with('message', 'Manager account has been deleted successfully');
                }
        } catch (\Throwable $th) {
            session()->flash('response', 'danger');
                    return redirect()->back()->with('message', 'Manager account has not been deleted.');
        }
       
        //
    }
}
