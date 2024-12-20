<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Academic;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function onLogin(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $student = Student::where('nim', $validated['npm'])->first();

        if (!$student) {
            return redirect()->route('login')->with(
                'error',
                'Akun tidak ditemukan atau tidak terdaftar!'
            );
        }

        $isPasswordMatch = Hash::check($validated['password'], $student->password);

        if (!$isPasswordMatch) {
            return redirect()->route('login')->with(
                'error',
                'Kata sandi yang dimasukkan tidak sesuai!'
            );
        }

        Auth::guard('student')->login($student);

        return redirect()->route('dashboard');
    }

    public function register(): View
    {
        $academics = Academic::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->get();

        return view('auth.register', compact('academics'));
    }

    public function onRegister(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($request->validated()['password']);

        if (Student::create($validated)) {
            return redirect()->route('login')->with(
                'success',
                'Berhasil melakukan registrasi. Silahlan login dengan akun terdaftar'
            );
        }

        return redirect()->route('register')->with(
            'error',
            'Gagal melakukan registrasi akun, silahkan ulangi kembali'
        );
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
