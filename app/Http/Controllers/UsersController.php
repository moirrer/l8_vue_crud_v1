<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UsersController extends Controller
{
    public static function get($id = null){
        if($id == null)
            $user = User::get();
        else
            $user = User::find($id);
            
        if($user != null)
            return response()->json(['msg' => '', 'user' => $user], 200);
        else
            return response()->json(['msg' => 'Nenhum usuário encontrado'], 203);
    }

    public static function post(Request $request){
        Validator::make($request->all(), [
            'name'     => ['required'],
            'email'    => ['required'],
            'password' => ['required'],
        ])->validate();
  
        $request->merge(['password' => \Hash::make($request->password)]);

        User::create($request->all());
  
        return redirect()->back()->with('message', 'Usuário criado.');
    }

    public function update(Request $request){
        Validator::make($request->all(), [
            'name'  => ['required'],
            'email' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            User::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'Sucesso.');
        }
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            User::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }

}
