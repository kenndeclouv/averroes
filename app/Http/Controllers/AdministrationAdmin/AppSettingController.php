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
            'nip_prefix' => 'nullable|string|max:10',
            'nip_start_number' => 'required|integer|min:1',
            'nip_padding' => 'required|integer|min:1|max:10',
            'nip_suffix' => 'nullable|string|max:10',
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
            'nip_prefix.string' => 'Prefix harus berupa string',
            'nip_prefix.max' => 'Prefix maksimal 10 karakter',
            'nip_start_number.required' => 'Start number harus diisi',
            'nip_start_number.integer' => 'Start number harus berupa angka',
            'nip_start_number.min' => 'Start number minimal 1',
            'nip_padding.required' => 'Padding harus diisi',
            'nip_padding.integer' => 'Padding harus berupa angka',
            'nip_padding.min' => 'Padding minimal 1',
            'nip_padding.max' => 'Padding maksimal 10',
            'nip_suffix.string' => 'Suffix harus berupa string',
            'nip_suffix.max' => 'Suffix maksimal 10 karakter',
        ]);

        $appSetting = AppSetting::firstOrCreate([], $request->only([
            'nis_prefix',
            'nis_start_number',
            'nis_padding',
            'nis_suffix',
            'nip_prefix',
            'nip_start_number',
            'nip_padding',
            'nip_suffix'
        ]));

        if (!$appSetting->wasRecentlyCreated) {
            $appSetting->update($request->only([
                'nis_prefix',
                'nis_start_number',
                'nis_padding',
                'nis_suffix',
                'nip_prefix',
                'nip_start_number',
                'nip_padding',
                'nip_suffix'
            ]));
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diubah');
    }
}
