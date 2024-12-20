@extends('layouts.auth')

@section('title', 'Login Account')

@section('content')
    <div class="bg-white shadow-gray-300 border shadow-lg p-6 rounded-lg flex flex-col lg:w-[400px]">
        <h1 class="font-semibold text-2xl mb-4 tracking-wide text-neutral">Login</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="flex flex-col mb-2">
                <label for="npm" class="text-sm font-medium text-neutral tracking-wide mb-1 required">NPM</label>
                <input type="text" id="npm" name="npm" placeholder="Masukkan npm"
                       class="border rounded focus:outline-none px-2 py-2 text-neutral font-light text-sm focus:border-primary"
                       autofocus autocomplete="off">
            </div>
            <div class="flex flex-col mb-4">
                <label for="password"
                       class="text-sm font-medium text-neutral tracking-wide mb-1 required">Password</label>
                <input type="password" id="password" name="password" placeholder="* * * * * * * *"
                       class="border rounded focus:outline-none px-2 py-2 text-neutral font-light text-sm">
            </div>
            <button type="submit"
                    class="w-full p-2 bg-primary rounded text-white text-sm font-semibold tracking-wide">Login
            </button>
            <div class="w-full text-center mt-4">
                <span class="text-sm text-gray-400 tracking-wide">Belum mempunyai akun?
                    <a href="{{ route('register') }}" class="text-primary">Register</a>
                </span>
            </div>
        </form>
    </div>
@endsection
