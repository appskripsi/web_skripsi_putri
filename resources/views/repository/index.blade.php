@extends('layouts.app')

@section('title', 'Books')

@section('content')
    <div class="lg:grid lg:grid-cols-5 min-h-[calc(100vh-65px)] w-full lg:px-32 py-4">
        {{-- Filter Section --}}
        <aside class="lg:flex flex-col mr-8 hidden">
            <h1 class="tracking-wider text-md font-bold mb-2">Filter</h1>
            <hr class="mb-4">
            <form action="{{ route('repository.index') }}" method="GET" class="flex flex-col space-y-4">
                {{-- Search --}}
                <input type="text" name="search" class="p-2 text-xs rounded border outline-none focus:outline-none"
                       placeholder="Cari jurnal atau skripsi...">
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
                    <label for="type" class="tracking-wider text-sm font-medium">
                        Tipe</label>
                    <select name="category" id="category" class="select select-bordered select-sm w-full max-w-xs">
                        <option disabled selected>Pilih Tipe</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                    <a href="{{ route('book.index') }}"
                       class="btn btn-sm btn-error text-white font-medium w-fit">Reset</a>
                </div>
            </form>
        </aside>

        {{-- Repository Section --}}
        <main class="lg:col-span-4 max-md:px-4">
            <div>
                <h2 class="text-lg font-bold mb-4 max-md:text-center max-md:text-xl">Repository</h2>
            </div>

            <div class="items-center gap-2 mb-4 max-md:flex hidden">
                <form action="{{ route('repository.index') }}" method="GET">
                    <input type="text" name="search" class="p-2 rounded border focus:outline-none text-sm"
                           placeholder="Cari Buku...">
                    <button class="btn btn-primary btn-sm text-white font-medium">Cari</button>
                    <a href="{{ route('repository.index') }}"
                       class="btn btn-error btn-sm text-white font-medium">Reset</a>
                </form>
            </div>

            @foreach ($repositories as $repository)
                <div class="py-1.5 text-justify">
                    <span class="tracking-widest">{{ $repository->student->name }} ({{ $repository->created_at->format('Y') }})
                        <a href="{{route('repository.show', $repository->id)}}"
                           class="text-primary underline italic">{{ $repository->title }}</a>
                        {{ $repository->type->name }}, Institut Informatika dan Bisnis Darmajaya</span>
                </div>
            @endforeach

            {{-- Pagination --}}
            @if ($repositories->isNotEmpty())
                <div class="join mt-8">
                    @if ($repositories->onFirstPage())
                        <span class="join-item btn btn-disabled">
                            << </span>
                    @else
                        <a href="{{ $repositories->previousPageUrl() }}" class="join-item btn">
                            << </a>
                    @endif

                    @foreach ($repositories->getUrlRange(1, $repositories->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                           class="join-item btn {{ $page == $repositories->currentPage() ? 'btn-active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($repositories->hasMorePages())
                        <a href="{{ $repositories->nextPageUrl() }}" class="join-item btn">>></a>
                    @else
                        <span class="join-item btn btn-disabled">>></span>
                    @endif
                </div>
            @endif
        </main>
    </div>
@endsection
