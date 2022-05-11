<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    public function change(Request $request){
        $this->authorize('update-admin-password',User::class);
        if(Auth::check(Auth::user()->password == $request->c_password)){
            $validate =  Validator::make($request->all(), [
                'n_password' => ['required', 'string', 'min:8'],
            ]);
            if($validate->fails()){
                return redirect()->route('admin.secuirety')->with('error', 'New Password is not correct format | min 8 characters');
            }else{
          // Initialise the 2FA class
          $google2fa = app('pragmarx.google2fa');

          // store registration data in an array
          $registration_data = $request->all();
          $registration_data['email'] = Auth::user()->email;

          // Create new secret key to the registration data
          $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();

          // store registration data to the user session for new request
          session(['registration_data' => $registration_data]);

          // Create the QR image.
          $QR_Image = $google2fa->getQRCodeInline(
              config('app.name'),
              $registration_data['email'],
              $registration_data['google2fa_secret']
          );
           // Send the QR barcode image to our view
           return view('Admin.Pages.confirm', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
            }
        }else{
            return redirect()->route('admin.secuirety')->with('error', 'Current Password is not correct');

        }
    }
    public function update(Request $request){
        $this->authorize('update-admin-password',User::class);
        $registration_data = session('registration_data');
            $pass = User::where('id',Auth::user()->id)->update([
                'password' => bcrypt($registration_data['n_password']),
                'google2fa_secret' => $registration_data['google2fa_secret'],
            ]);
            if($pass){
                return redirect()->route('admin.secuirety')->with('success', 'Password Updated Successfully');
            }

    }
}
