<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;

class AppSettingController extends Controller
{
    public function index()
    {
        $appSetting = AppSetting::first();
        $nisPreview = generateNIS();
        return view('roles.AdministrationAdmin.settings.index', compact('appSetting', 'nisPreview'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nis_prefix' => 'nullable|string|max:10',
            'nis_start_number' => 'required|integer|min:1',
            'nis_padding' => 'required|integer|min:1|max:10', 
            'nis_suffix' => 'nullable|string|max:10',
        ], [
            'nis_prefix.string' => 'Prefix harus berupa string',
            'nis_prefix.max' => 'Prefix maksimal 10 karakter',
            'nis_start_number.required' => 'Start number harus diisi',
            'nis_start_number.integer' => 'Start number harus berupa angka',
            'nis_start_number.min' => 'Start number minimal 1',
            'nis_padding.required' => 'Padding harus diisi',
            'nis_padding.integer' => 'Padding harus berupa angka',
            'nis_padding.min' => 'Padding minimal 1',
            'nis_padding.max' => 'Padding maksimal 10',
            'nis_suffix.string' => 'Suffix harus berupa string',
            'nis_suffix.max' => 'Suffix maksimal 10 karakter',
        ]);

        $appSetting = AppSetting::firstOrCreate([], $request->only([
            'nis_prefix',
            'nis_start_number', 
            'nis_padding',
            'nis_suffix'
        ]));

        if (!$appSetting->wasRecentlyCreated) {
            $appSetting->update($request->only([
                'nis_prefix',
                'nis_start_number',
                'nis_padding', 
                'nis_suffix'
            ]));
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diubah');
    }
}
