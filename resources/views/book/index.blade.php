@extends('layouts.app')

@section('title', 'Books')

@section('content')
    <div class="lg:grid lg:grid-cols-5 min-h-[calc(100vh-65px)] w-full lg:px-32 py-4">
        {{-- Filter Section --}}
        <aside class="lg:flex flex-col mr-8 hidden">
            <h1 class="tracking-wider text-md font-bold mb-2">Filter</h1>
            <hr class="mb-4">
            <form action="" method="GET" class="flex flex-col space-y-4">
                {{-- Search --}}
                <input type="text" name="search" class="p-2 text-xs rounded border outline-none focus:outline-none"
                    placeholder="Cari buku...">
                {{-- Date Filter --}}
                <fieldset class="flex flex-col gap-2">
                    <legend class="tracking-wider text-sm font-medium mb-2">Tanggal
                    </legend>
                    <div class="inline-flex gap-2 items-center">
                        <input type="radio" name="date" id="newest" value="newest">
                        <label for="newest" class="text-sm tracking-wide">Paling Baru</label>
                    </div>
                    <div class="inline-flex gap-2 items-center">
                        <input type="radio" name="date" id="oldest" value="oldest">
                        <label for="oldest" class="text-sm tracking-wide">Terdahulu</label>
                    </div>
                </fieldset>

                {{-- Category Filter --}}
                <div class="space-y-1">
                    <label for="category" class="tracking-wider text-sm font-medium">
                        Kategori</label>
                    <select name="category" id="category" class="select select-bordered select-sm w-full max-w-xs">
                        <option disabled selected>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Academic Filter --}}
                <div class="space-y-1">
                    <label for="academic" class="tracking-wider text-sm font-medium">
                        Program Studi</label>
                    <select name="academic" id="academic" class="select select-bordered select-sm w-full max-w-xs">
                        <option disabled selected>Pilih Program Studi</option>
                        @foreach ($academics as $academic)
                            <option value="{{ $academic->id }}">{{ $academic->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="inline-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary text-white font-medium w-fit">Filter</button>
                    <a href="{{ route('book.index') }}" class="btn btn-sm btn-error text-white font-medium w-fit">Reset</a>
                </div>
            </form>
        </aside>

        {{-- Book Section --}}
        <main class="lg:col-span-4 max-md:px-4">
            <div>
                <h2 class="text-lg font-bold mb-4 max-md:text-center max-md:text-xl">Daftar Buku</h2>
            </div>

            <div class="items-center gap-2 mb-4 max-md:flex hidden">
                <form action="{{ route('book.index') }}" method="GET">
                    <input type="text" name="search" class="p-2 rounded border focus:outline-none text-sm"
                        placeholder="Cari Buku...">
                    <button class="btn btn-primary btn-sm text-white font-medium">Cari</button>
                    <a href="{{ route('book.index') }}" class="btn btn-error btn-sm text-white font-medium">Reset</a>
                </form>
            </div>

            <div class="grid lg:grid-cols-5 max-md:grid-cols-2 max-sm:grid-cols-2 lg:gap-4 max-md:gap-2 max-sm:gap-2">
                @foreach ($books as $book)
                    <div
                        class="bg-white rounded p-1 border border-gray-200 flex flex-col justify-center items-center max-md:mb-2">
                        <div class="w-[183px] h-[275px] overflow-hidden">
                            <img src="{{ asset('storage/' . $book->image) }}" alt="book-cover"
                                class="object-cover w-full h-full">
                        </div>

                        @php
                            $rating = round($book->ratings_avg_rating ?? 0, 1);
                            $full_star = floor($rating);
                            $half_star = $rating - $full_star >= 0.5 ? 1 : 0;
                            $empty_star = 5 - $full_star - $half_star;
                        @endphp

                        <div class="inline-flex items-center mt-2">
                            @for ($i = 0; $i < $full_star; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor

                            @if ($half_star)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @endif

                            @for ($i = 0; $i < $empty_star; $i++)
                                <i class="far fa-star text-gray-300"></i>
                            @endfor
                        </div>
                        <span class="mt-2 text-neutral text-sm text-center"
                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; display: inline-block;">
                            {{ $book->name }}
                        </span>
                        <div class="inline-flex items-center gap-2">
                            @if ($book->loans_count >= $book->stock)
                                <button disabled class="btn btn-outline btn-sm mt-2 mb-1 font-light uppercase text-xs">Out
                                    Stock</button>
                            @else
                                @auth('student')
                                    <a href="{{ route('loan.create', ['id' => $book->id]) }}"
                                        class="btn btn-outline btn-sm mt-2 mb-1 font-light uppercase text-xs">Pinjam</a>
                                @endauth
                            @endif
                            <a href="{{ route('book.show', $book->id) }}"
                                class="btn btn-outline btn-sm mt-2 mb-1 font-light uppercase text-xs">Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($books->isNotEmpty())
                <div class="join mt-8">
                    @if ($books->onFirstPage())
                        <span class="join-item btn btn-disabled">
                            << </span>
                            @else
                                <a href="{{ $books->previousPageUrl() }}" class="join-item btn">
                                    << </a>
                    @endif

                    @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="join-item btn {{ $page == $books->currentPage() ? 'btn-active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($books->hasMorePages())
                        <a href="{{ $books->nextPageUrl() }}" class="join-item btn">>></a>
                    @else
                        <span class="join-item btn btn-disabled">>></span>
                    @endif
                </div>
            @endif
        </main>
    </div>
@endsection
