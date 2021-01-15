<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customers;

class CustomersController extends Controller
{
    public static function get($id = null){
        if($id == null)
            $customer = Customers::get();
        else
            $customer = Customers::find($id);
            
        if($customer != null)
            return response()->json(['msg' => '', 'customer' => $customer], 200);
        else
            return response()->json(['msg' => 'Nenhum cliente encontrado'], 203);
    }

    public static function post(Request $request){
        Validator::make($request->all(), [
            'user_id'  => ['required'],
            'name'     => ['required'],
            'document' => ['required','min:6','max:12']
        ])->validate();

        Customers::create($request->all());
  
        return redirect()->back()->with('message', 'Cliente criado.');
    }

    public function update(Request $request){
        Validator::make($request->all(), [
            'name'     => ['required'],
            'document' => ['required','min:6','max:12'],
            'status'   => ['required'],
            'user_id'  => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Customers::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'Sucesso.');
        }
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            Customers::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
