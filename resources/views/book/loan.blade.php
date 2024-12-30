@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center p-4 lg:min-h-[calc(100vh-140px)] max-md:min-h-[calc(100vh-139px)]">
        <div class="p-4 bg-white border rounded-lg lg:w-2/5 max-md:w-full">
            <h1 class="lg:text-2xl max-md:text-xl font-semibold tracking-wide mb-4 text-center">Form Peminjaman Buku</h1>
            <hr class="h-0.5 bg-gray-200 mb-4">
            <form action="{{ route('loan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <div class="flex flex-col mb-4">
                    <label for="npm" class="font-semibold mb-1 text-sm tracking-wide text-neutral required">NPM</label>
                    <input type="text" readonly disabled value="{{ $student->nim }}" class="border rounded p-2 text-sm">
                </div>
                <div class="flex flex-col mb-4">
                    <label for="name" class="font-semibold mb-1 text-sm tracking-wide text-neutral required">Full
                        Name</label>
                    <input type="text" readonly disabled value="{{ $student->name }}" class="border rounded p-2 text-sm">
                </div>
                <div class="flex flex-col mb-4">
                    <label for="book"
                        class="font-semibold mb-1 text-sm tracking-wide text-neutral required">Academic</label>
                    <input type="text" readonly disabled value="{{ $book->name }}" class="border rounded p-2 text-sm">
                </div>
                <div class="flex flex-col mb-4">
                    <label for="name" class="font-semibold mb-1 text-sm tracking-wide text-neutral required">Tanggal
                        Peminjaman</label>
                    <input type="date" name="start_date" class="border rounded p-2 text-sm">
                    @error('start_date')
                        <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mb-4">
                    <label for="name" class="font-semibold mb-1 text-sm tracking-wide text-neutral required">Tanggal
                        Pemulangan</label>
                    <input type="date" name="end_date" class="border rounded p-2 text-sm">
                    @error('end_date')
                        <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" {{ $is_exist ? 'disabled' : '' }}
                    class="btn btn-primary text-white btn-sm text-center font-medium">Ajukan
                    Peminjaman</button>
                <a href="{{ route('book.index') }}" class="btn btn-light btn-sm font-medium ml-2">Batal</a>
                @if ($is_exist)
                    <br>
                    <br>
                    <span class="text-sm text-red-500">Kamu memiliki pinjaman yang sama dengan status pending. Klik <a
                            class="underline" href="{{ route('loan.index') }}">disini</a> untuk melihat.</span>
                @endif
            </form>
        </div>
    </div>
@endsection
