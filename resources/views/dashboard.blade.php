@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- s: Hero Section --}}
    <div class="relative h-[calc(100vh-64px)] border-t-2 border-t-gray-200">
        <img src="{{ Vite::asset('resources/img/background.png') }}" alt="background"
            class="absolute inset-0 w-full h-full object-cover pointer-events-none">

        <div class="flex flex-col items-center justify-center h-full w-full text-center">
            <h1 class="lg:text-4xl md:text-4xl text-3xl font-bold mb-4"><span class="text-primary">E</span> Library</h1>
            <span class="lg:text-lg md:text-lg text-sm leading-relaxed max-w-2xl mb-4 max-md:px-4">
                Merupakan sistem yang dapat digunakan untuk mencari buku yang ada di perpustakaan
                Institut Informatika dan Bisnis Darmajaya. Sistem ini juga dapat merekomendasikan buku
                sesuai dengan minat baca pengguna sesuai dengan kategori yang telah dipilih.
            </span>
            {{-- s: Search --}}
            <form action="{{ route('book.index') }}" method="GET"
                class="inline-flex justify-center items-center w-1/3 gap-2">
                <label class="input input-bordered flex items-center gap-2">
                    <input name="search" type="text" class="grow" placeholder="Search" />
                    <i class="fa-solid fa-search"></i>
                </label>
                <button type="submit" class="btn btn-primary text-white">Search</button>
            </form>
            {{-- e: Search --}}
        </div>
    </div>
    {{-- e: Hero Section --}}

    {{-- s: Book Recomendation --}}
    @auth
        {{-- TO DO --}}
    @endauth
    {{-- e: Book Recomendation --}}

    {{-- s: New Book --}}
    @if (!$newest_book->isEmpty())
        <section class="bg-slate-50 mt-4">
            <h4 class="mx-auto text-3xl font-bold text-center py-6">Buku Terbaru</h4>
            <div class="grid lg:grid-cols-4 md:grid-cols-3 md:px-16 lg:px-32 max-md:px-4 gap-4 py-4">
                @foreach ($newest_book as $newest)
                    <a href="{{ route('book.show', $newest->id) }}"
                        class="flex p-2 bg-white rounded-md space-x-4 w-full cursor-pointer hover:scale-105 hover:duration-150 hover:transition-all shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $newest->image) }}" alt="book-cover" class="w-1/2">
                        <div class="flex flex-col justify-between w-full">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold line-clamp-4 mb-2">{{ $newest->name }}</span>
                                <span class="text-xs text-gray-400 line-clamp-2">{{ $newest->author }}</span>
                            </div>
                            <span
                                class="text-xs text-gray-400 font-medium">{{ $newest->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
    {{-- e: New Book --}}

    {{-- s: Location --}}
    <div class="flex flex-col w-full items-center justify-center">
        <h4 class="mx-auto text-3xl font-bold text-center py-6">Lokasi</h4>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.2591089272805!2d105.24706977463441!3d-5.377407894601497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40dac5f1bf788b%3A0x2458668e7c62825f!2sInstitut%20Informatika%20dan%20Bisnis%20Darmajaya!5e0!3m2!1sid!2sid!4v1733036889962!5m2!1sid!2sid"
            class="lg:w-2/3 max-md:px-4 w-full min-h-[400px] mb-8 border-none shadow-lg" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    {{-- e: Location --}}
@endsection
