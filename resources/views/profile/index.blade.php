@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center p-4 lg:min-h-[calc(100vh-140px)] max-md:min-h-[calc(100vh-139px)]">
        <div class="p-4 bg-white border rounded-lg lg:w-2/5 max-md:w-full">
            <h1 class="lg:text-2xl max-md:text-xl font-semibold tracking-wide mb-4 text-center">Update Profile</h1>
            <hr class="h-0.5 bg-gray-200 mb-4">
            <form action="{{ route('profile.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-col mb-4">
                    <label class="font-semibold mb-1 text-sm tracking-wide text-neutral required">NPM</label>
                    <input type="text" readonly disabled value="{{ $student->nim }}" class="border rounded p-2 text-sm">
                </div>
                <div class="flex flex-col mb-4">
                    <label for="name" class="font-semibold mb-1 text-sm tracking-wide text-neutral required">Full
                        Name</label>
                    <input type="text" name="name" value="{{ $student->name }}" class="border rounded p-2 text-sm">
                    @error('name')
                        <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mb-4">
                    <label for="password" class="font-semibold mb-1 text-sm tracking-wide text-neutral">Password</label>
                    <input type="password" name="password" class="border rounded p-2 text-sm">
                    @error('password')
                        <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mb-4">
                    <label for="academic_id"
                        class="font-semibold mb-1 text-sm tracking-wide text-neutral required">Academic</label>
                    <select name="academic_id" id="academic_id" class="select select-bordered w-full">
                        <option value="" disabled>Pilih program studi</option>
                        @foreach ($academics as $academic)
                            <option value="{{ $academic->id }}"
                                {{ $student->academic_id == $academic->id ? 'selected' : '' }}>{{ $academic->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_id')
                        <span class="text-xs text-red-500 py-1">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary text-white btn-sm text-center font-medium">Update</button>
                <a href="{{ route('book.index') }}" class="btn btn-light btn-sm font-medium ml-2">Batal</a>
            </form>
        </div>
    </div>
@endsection
