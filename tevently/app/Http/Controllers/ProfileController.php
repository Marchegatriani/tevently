<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
	// show edit form (expects view resources/views/profile/edit.blade.php)
	public function edit(Request $request)
	{
		$user = $request->user();
		return view('profile.edit', compact('user'));
	}

	// update profile (name / email as example)
	public function update(Request $request)
	{
		$user = $request->user();

		$data = $request->validate([
			'name' => 'required|string|max:255',
			'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
			// add other fields as required
		]);

		$user->update($data);

		return redirect()->route('profile.edit')->with('success', 'Profile updated.');
	}

	// destroy account (used by organizer.delete-account)
	public function destroy(Request $request)
	{
		$user = $request->user();

		// optional: only allow if confirmed (already protected by form)
		Auth::logout();

		// delete user record
		$user->delete();

		// invalidate session / regenerate CSRF token
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/')->with('success', 'Akun berhasil dihapus.');
	}
}
