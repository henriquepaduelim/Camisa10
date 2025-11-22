<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Setting::all()->pluck('valor', 'chave'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->input('settings') as $chave => $valor) {
            Setting::updateOrCreate(['chave' => $chave], ['valor' => $valor]);
        }

        return response()->json(['data' => Setting::all()->pluck('valor', 'chave')]);
    }
}
