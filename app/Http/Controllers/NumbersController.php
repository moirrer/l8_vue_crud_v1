<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Numbers;

class NumbersController extends Controller
{

    public static function get($id = null){
        if($id == null)
            $number = Numbers::get();
        else
            $number = Numbers::find($id);
            
        if($number != null)
            return response()->json(['msg' => '', 'number' => $number], 200);
        else
            return response()->json(['msg' => 'Nenhum número encontrado'], 203);
    }

    public static function post(Request $request){
        Validator::make($request->all(), [
            'customer_id' => ['required'],
            'number'      => ['required','min:8','max:14'],
        ])->validate();

        Numbers::create($request->all());
  
        return redirect()->back()->with('message', 'Número criado.');
    }

    public function update(Request $request){
        Validator::make($request->all(), [
            'customer_id' => ['required'],
            'number'      => ['required','min:8','max:14'],
            'status'      => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Numbers::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'Sucesso.');
        }
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            Numbers::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
