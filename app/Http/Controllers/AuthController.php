<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

// use function PHPSTORM_META\map;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('tenant.auth.login');
    }

    public function post_login(Request $request)
    {
        // dd($request->all());
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($data)) {
            Session::flash('error', 'Email or Password is wrong');
            Alert::toast('Email or Password is wrong', 'error');
            return redirect()->route('login')->withErrors('Email or Password is wrong');
        }
        return redirect()->route('dashboard');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('tenant.auth.register');
    }

    public function post_register(Request $request)
    {
        // dd($request->all());
        try {
            $messages = [
                'photo.required' => 'Foto harus tersedia',
                'photo.max' => 'ukuran foto maksimal 2mb',
                'photo.image' => 'yang diupload harus berupa foto',
                'name.required' => 'nama harus diisi',
                'username.required' => 'username harus diisi',
                'sex.required' => 'jenis kelamin harus diisi',
                'password.required' => 'password harus diisi',
                'phone.required' => 'nomor telp harus diisi'
            ];

            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:png,jpg,jpg|max:2048',
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'sex' => 'required|in:0,1',
                'password' => 'required|min:8',
                'phone' => 'required|min:9'
            ]);


            if (!$validator->fails()) {
                $user = new User();

                $image = $request->file('image');
                $image_name = time() . 'user-' . $request->username  . $image->getClientOriginalExtension();
                Storage::putFileAs('public/uploads/user/', $image, $image_name);
                $user->name = $request->name;
                $user->username = $request->username;
                $user->sex = $request->sex;
                $user->email = $request->email;
                $user->roles = 'kantin';
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->image = $image_name;
                $user->save();
                Alert::success('Register Success', 'Please Login');
                return redirect()->route('login');
            }
            Alert::success('Tes', $validator->messages()->all());
            return redirect()->route('register')->withInput();
        } catch (Exception $error) {
            dd($error->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgot()
    {
        return view('tenant.auth.forgot-password');
    }

    public function sent_forgot_password()
    {
        return view('tenant.auth.sent-forgot-password');
    }

    public function success_reset()
    {
        return view('tenant.auth.success-reset');
    }
}
