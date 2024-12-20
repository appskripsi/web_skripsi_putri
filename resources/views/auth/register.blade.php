@extends('layouts.auth')

@section('title', 'Register Account')

@section('content')
    <div class="bg-white shadow-gray-300 border shadow-lg p-6 rounded-lg flex flex-col lg:w-[400px]">
        <h1 class="font-semibold text-2xl mb-4 tracking-wide text-neutral">Register</h1>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="flex flex-col mb-2">
                <label for="nim" class="text-sm font-medium text-neutral tracking-wide mb-1 required">NPM</label>
                <input type="text" id="nim" name="nim" placeholder="Masukkan nim atau npm"
                       class="border rounded focus:outline-none px-2 py-2 text-neutral font-light text-sm focus:border-primary"
                       autofocus autocomplete="off">
                @error('nim')
                <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-2">
                <label for="name" class="text-sm font-medium text-neutral tracking-wide mb-1 required">Fullname</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap"
                       class="border rounded focus:outline-none px-2 py-2 text-neutral font-light text-sm focus:border-primary"
                       autofocus autocomplete="off">
                @error('name')
                <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-4">
                <label for="gender" class="text-sm font-medium text-neutral tracking-wide mb-1 required">Gender</label>
                <select name="gender" id="gender" class="select select-bordered w-full">
                    <option value="" disabled selected>Pilih jenis kelamin</option>
                    <option value="P">Perempuan</option>
                    <option value="L">Laki - Laki</option>
                </select>
                @error('gender')
                <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-4">
                <label for="password"
                       class="text-sm font-medium text-neutral tracking-wide mb-1 required">Password</label>
                <input type="password" id="password" name="password" placeholder="* * * * * * * *"
                       class="border rounded focus:outline-none px-2 py-2 text-neutral font-light text-sm">
                @error('password')
                <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-4">
                <label for="academic_id"
                       class="text-sm font-medium text-neutral tracking-wide mb-1 required">Academic</label>
                <select name="academic_id" id="academic_id" class="select select-bordered w-full">
                    <option value="" disabled selected>Pilih program studi</option>
                    @foreach ($academics as $academic)
                        <option value="{{ $academic->id }}">{{ $academic->name }}</option>
                    @endforeach
                </select>
                @error('academic_id')
                <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit"
                    class="w-full p-2 bg-primary rounded text-white text-sm font-semibold tracking-wide">Login
            </button>
            <div class="w-full text-center mt-4">
                <span class="text-sm text-gray-400 tracking-wide">Sudah mempunyai akun?
                    <a href="{{ route('login') }}" class="text-primary">Login</a>
                </span>
            </div>
        </form>
    </div>
@endsection
