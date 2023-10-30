<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;



class RegisController extends Controller
{
    public function index()
    {
        return view('auth.signup');
    }
    public function store(Request $request)
    {
        // $validateData  = $request -> validate([
        //     'name'      => 'required',
        //     'email'     => 'required|email|unique:users',
        //     'password'  => 'required|confirmed|min:5|max:20'
        // ]);

        // User::create($validateData);

        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed'
        ]);

        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password'))
        ]);

        //assign role
        $user->assignRole($request->input('role')); 

        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('users.index')->with(['error' => 'Data Gagal Disimpan!']);
        }



    }
    
}