<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
	public function edit(Request $request)
	{
		$user = $request->user();
		return view('profile.edit', compact('user'));
	}

	public function update(Request $request)
	{
		$user = $request->user();

		$data = $request->validate([
			'name' => 'required|string|max:255',
			'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
		]);

		$user->update($data);

		return redirect()->route('profile.edit')->with('success', 'Profile updated.');
	}

	public function destroy(Request $request)
	{
		$user = $request->user();

		Auth::logout();

		$user->delete();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/')->with('success', 'Akun berhasil dihapus.');
	}
}
