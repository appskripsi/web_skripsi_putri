<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Academic;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $student = Auth::guard('student')->user();

        $academics = Academic::where('status', 1)->get();

        return View(
            'profile.index',
            compact(['student', 'academics'])
        );
    }

    public function update(ProfileUpdateRequest $request, Student $profile): RedirectResponse
    {
        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($profile->update($validated)) {
            return redirect()->route('profile.index')->with('success', 'Berhasil update profile');
        }

        return redirect()->route('profile.index')->with('error', 'Gagal update profile');
    }
}
