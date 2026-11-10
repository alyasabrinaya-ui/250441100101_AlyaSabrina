<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
   
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->update($request->validated());

        
        $user->buatAnggota()->update(['nama' => $user->name, 'email' => $user->email]);

        return redirect()->route('profile.edit')->with('sukses', 'Profil berhasil diperbarui.');
    }
}