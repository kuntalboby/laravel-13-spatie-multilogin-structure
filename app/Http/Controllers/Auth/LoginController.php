<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Admin and Manager login page
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    // Admin and Manager authentication
    public function adminLogin(Request $request)
    {
        // User::where('email', 'admin@mailinator.com')->first()->assignRole('admin');
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //   return $request;
        $user = User::where('email', $credentials['email'])->where('status',0)->first();
        // return $user;
        // dd($user->getRoleNames(), $user->hasAnyRole(['admin', 'manager']));
        if (
            !$user ||
            !Hash::check($credentials['password'], $user->password) 
            || !$user->hasAnyRole(['admin', 'manager'])
        ) {            
            return back()
                ->withErrors([
                    'email' => 'Invalid login credentials.',
                ])
                ->onlyInput('email');
        }
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    // Customer login page
    public function showCustomerLogin()
    {
        return view('auth.customer-login');
    }

    // Customer authentication
    public function customerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            !$user ||
            !Hash::check($credentials['password'], $user->password) ||
            !$user->hasRole('customer')
        ) {
            return back()
                ->withErrors([
                    'email' => 'Invalid login credentials.',
                ])
                ->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // return redirect()->route('customer.dashboard');
    }

    public function generateResetPassword(Request $request){
        $request->validate(['email' => 'required|email']);
        if($request){
            try {
               $isExistes =  User::where('email', $request->email)
                ->where('is_deleted', '0')
                ->where('status','0')
                    ->exists();
                    if(!$isExistes){
                   
                         session()->flash('response', 'danger');
                         return redirect()->back()->with('message', 'We could not find a user with that email address.');

                    }
                     $status = Password::broker()->sendResetLink(
                            $request->only('email')
                        );
                        if($status === Password::RESET_LINK_SENT){
                            session()->flash('response', 'success');
                            return redirect()->back()->with('message', 'Mail has been sent to your email address.');

                        }else{
                            session()->flash('response', 'danger');
                            return redirect()->back()->with('message', 'Mail has not been sent');

                        }


            } catch (\Throwable $th) {
                return response()->json([
                        'message' => 'Something went wrong while processing your request.',
                        'error' => $th->getMessage()
                    ], 500);
            }
        }
    }
    public function updatePassword(Request $request){
            $request->validate([
                    'token' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                ]);

             try {
                            $status = Password::reset(
                            $request->only('email', 'password', 'password_confirmation', 'token'),
                            function (User $user, string $password) {
                                $user->forceFill([
                                    'password' => Hash::make($password)
                                ])->setRememberToken(Str::random(60));
                    
                                $user->save();
                    
                                event(new PasswordReset($user));
                            }
                        );
                    
                    if($status === Password::PasswordReset){
                        session()->flash('response', 'success');
                        return redirect()->route('admin.login')->with('message', 'Password has been updated successfully.');
                    }else{
                        session()->flash('response', 'danger');
                        return redirect()->back()->with('message', 'Something went wrong.Password has not been updated.');

                    }
             } catch (\Throwable $th) {
                session()->flash('response', 'danger');
                return redirect()->back()->with('message', $th);

             }
    }


}