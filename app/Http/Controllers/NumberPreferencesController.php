<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\NumberPreferences;

class NumberPreferencesController extends Controller
{

    public static function get($id = null){
        if($id == null)
            $number_preference = NumberPreferences::get();
        else
            $number_preference = NumberPreferences::find($id);
            
        if($number_preference != null)
            return response()->json(['msg' => '', 'number_preference' => $number_preference], 200);
        else
            return response()->json(['msg' => 'Nenhuma preferencia de número encontrada'], 203);
    }

    public static function post(Request $request){
        Validator::make($request->all(), [
            'number_id' => ['required'],
            'name'      => ['required'],
            'value'     => ['required'],
        ])->validate();

        NumberPreferences::create($request->all());
  
        return redirect()->back()->with('message', 'Preferencia criada.');
    }

    public function update(Request $request){
        Validator::make($request->all(), [
            'number_id' => ['required'],
            'name'      => ['required'],
            'value'     => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            NumberPreferences::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'Sucesso.');
        }
    }

    public function destroy(Request $request){
        if ($request->has('id')) {
            NumberPreferences::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
