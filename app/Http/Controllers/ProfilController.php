<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class ProfilController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth'); 
        //  $this->middleware(['permission:users.index|users.create|users.edit|users.delete']);
    }
    public function index()
    {
        $profil=User::where('id', Auth::user()->id)->first();
        return view('profil.index',compact('profil'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
            'current_password' => 'required|min:8',
        ],
        [
            'password.regex' => 'Password harus mengandung setidaknya satu huruf kecil, satu huruf besar, satu angka, dan satu karakter khusus.'
        ]);
    
        if (!Hash::check($request->input('current_password'), Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }
    
        $user = User::find(Auth::user()->id);
    
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
            $user->password_update = now();
            $user->save();
        }
    
        if ($user) {
           
            return redirect('/profil')->with('status', 'Password Berhasil Di Update');
        } else {
       
            return redirect('/profil')->with('error', 'Password Gagal Di Update');
        }
    }
    
    
    public function update_image(Request $request)
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        'profile_photo_path' => 'image|mimes:png,jpg,jpeg|max:2000',
    ]);

    $user = User::find(Auth::user()->id);

    // Update name and email
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->save();

    // Update profile image if provided
    if ($request->hasFile('profile_photo_path')) {
        Storage::disk('local')->delete('public/staff/' . $user->profile_photo_path);

        $profile_photo_path = $request->file('profile_photo_path');
        $profile_photo_path->storeAs('public/staff', $profile_photo_path->hashName());

        $user->profile_photo_path = $profile_photo_path->hashName();
        $user->save();
    }

    // if ($user) {
    //     Alert::success('success', 'Berhasil Di Update');
    // } else {
    //     Alert::error('error', 'Gagal Di Update');
    // }

    return redirect('/profil')->with('status', ' Edit Profil Berhasil Di Update');
}

}
