<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('valor', 'chave');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nome_loja' => 'nullable|string|max:255',
            'email_contato' => 'nullable|email',
            'cor_primaria' => 'nullable|string|max:20',
            'footer_texto' => 'nullable|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['chave' => $key], ['valor' => $value]);
        }

        return back()->with('success', 'Configurações salvas.');
    }
}
