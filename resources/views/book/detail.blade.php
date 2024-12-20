@extends('layouts.app')

@section('content')
    <div class="min-h-[calc(100vh-65px)] lg:w-10/12 lg:px-2 lg:py-16 max-md:p-4 mx-auto">
        <div class="grid lg:grid-cols-5 max-md:grid-cols-1 lg:gap-4">
            <div class="max-md:mb-4 max-md:mx-auto">
                <img src="{{ asset('storage/' . $book->image) }}" alt="book-cover">
            </div>
            <div class="col-span-4">
                <h1 class="max-md:tracking-wider lg:text-xl lg:font-bold">{{ $book->name }}</h1>
                <h6 class="max-md:text-sm max-md:tracking-wider mt-1 mb-2">Author: {{ $book->author }}</h6>
                @php
                    $full_star = floor($rating);
                    $half_star = $rating - $full_star >= 0.5 ? 1 : 0;
                    $empty_star = 5 - $full_star - $half_star;
                @endphp
                <div class="inline-flex items-center mt-2 mb-4">
                    @for ($i = 0; $i < $full_star; $i++)
                        <i class="fas fa-star text-warning"></i>
                    @endfor

                    @if ($half_star)
                        <i class="fas fa-star-half-alt text-warning"></i>
                    @endif

                    @for ($i = 0; $i < $empty_star; $i++)
                        <i class="far fa-star text-gray-300"></i>
                    @endfor

                    <span class="ml-2 text-sm">({{ $rating }} / 5)</span>
                </div>
                <h6 class="mb-2">Deskripsi: {{ $book->description }}</h6>
                <h6 class="mb-2">Lokasi: {{ $book->location }}</h6>
                <h6 class="mb-2">Kategori: <span
                        class="badge badge-primary badge-md text-white">{{ $book->category->name }}</span>
                </h6>
                <h6 class="mb-4">Program Studi: <span
                        class="badge badge-warning badge-md">{{ $book->academic->name }}</span></h6>
                @auth('student')
                    @if ($book->loan_count <= $book->stock)
                        <a href="{{ route('loan.create', ['id' => $book->id]) }}"
                            class="btn btn-primary btn-sm text-white uppercase">Pinjam</a>
                    @else
                        <span class="text-error">Out of Stock</span>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Rating History --}}
        <hr class="h-0.5 border bg-gray-300 mt-4 mb-4">

        <div>
            <h1 class="lg:text-xl font-bold tracking-wider mb-4">Rating Pengguna</h1>
            @if (!$book->ratings->isEmpty())
                <div class="grid lg:grid-cols-5 max-md:grid-cols-1 lg:gap-4 max-md:gap-2">
                    @foreach ($book->ratings as $rating)
                        <div class="border rounded-xl border-gray-300 p-2 inline-flex items-center space-x-4">
                            <img src="{{ Vite::asset('resources/img/user.png') }}" width="30px" alt="user-profile">
                            <div class="flex flex-col">
                                <span class="text-xs line-clamp-1">{{ $rating->student->name }}</span>
                                <span class="text-xs">Rating: {{ $rating->rating }} <i
                                        class="fas fa-star text-yellow-500"></i></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12">
                    <span class="bg-gray-100 rounded-3xl text-sm p-2">Belum ada rating yang diberikan ...</span>
                </div>
            @endif
        </div>
    </div>
@endsection
