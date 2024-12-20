@extends('layouts.app')

@section('title', 'Feedback')

@section('content')
    <div class="w-full lg:py-8 py-4 h-[calc(100vh-139px)] lg:h-[calc(100vh-140px)]">
        @if (!$student->feedback)
            <h1 class="text-center tracking-wide lg:text-3xl text-2xl font-bold text-neutral">Feedback</h1>
            <h6 class="text-center max-md:text-xs">Berikan masukan serta saran kepada kami.</h6>

            <form action="{{ route('feedback.store') }}" class="mt-4" method="POST">
                @csrf
                <div class="flex flex-col max-md:px-4 lg:px-80">
                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"
                        class="border focus:outline-none rounded p-2 w-full text-sm text-neutral focus:border-primary mb-2"
                        placeholder="Masukkan deskripsi kritik atau saran."></textarea>
                    @error('deskripsi')
                        <span class="text-sm mt-1 mb-4 text-red-500">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn btn-primary text-white min-w-28 w-fit">Submit</button>
                </div>
            </form>
        @else
            <div class="flex flex-col items-center mt-24 w-full">
                <img src="{{ Vite::asset('resources/img/thankyou.png') }}" alt="thankyou message"
                    class="lg:w-1/5 w-1/2 mb-4">
                <h1 class="text-center tracking-wide text-neutral font-medium max-md:text-sm max-md:px-8">Terimakasih telah
                    memberikan
                    masukan
                    dan
                    saran kepada
                    kami!.</h1>
            </div>
        @endif
    </div>
@endsection
