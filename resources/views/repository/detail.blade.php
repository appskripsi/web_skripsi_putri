@extends('layouts.app')

@section('content')
    <div class="lg:w-8/12 mx-auto py-8 max-md:px-4">
        <a class="inline-flex items-center gap-2 text-sm hover:text-primary" href="{{route('repository.index')}}">
            <i class="fas fa-chevron-left text-xs"></i>
            Kembali
        </a>
        <h1 class="mb-6 mt-6 uppercase text-sm font-bold tracking-wider text-neutral">
            Repository {{config('custom.institute')}}
        </h1>
        <hr class="h-0.5 bg-black">

        <h1 class="mt-6 text-center text-3xl mb-6 tracking-wider">{{$repository->title}}</h1>
        <span class="text-sm">{{$repository->student->name}} ({{$repository->created_at->format('Y')}})
            <span class="italic text-gray-500">{{$repository->title}}.-. ({{$repository->type->name}})</span>
        </span>

        <h1 class="mt-6 text-xl tracking-wider">Abstract</h1>
        <p class="text-justify text-sm mt-2 mb-2 leading-loose tracking-wider">{{$repository->abstract}}</p>
        <span class="text-sm font-bold tracking-wide tracking-wider">Keywords:
            <span class="italic">{{$repository->keywords}}</span>
        </span>

        <table class="mt-6">
            <tr>
                <td class="py-2 text-sm uppercase tracking-widest font-medium mr-2 text-left text-gray-600">Item Type
                </td>
                <td class="px-2">:</td>
                <td class="tracking-widest text-sm">{{$repository->type->name}}</td>
            </tr>
            <tr>
                <td class="py-2 text-sm uppercase tracking-widest font-medium text-left text-gray-600">Faculty</td>
                <td class="px-2">:</td>
                <td class="tracking-widest text-sm">{{$repository->academic->faculty->name}}</td>
            </tr>
            <tr>
                <td class="py-2 text-sm uppercase tracking-widest font-medium text-left text-gray-600">Academic</td>
                <td class="px-2">:</td>
                <td class="tracking-widest text-sm">{{$repository->academic->name}}</td>
            </tr>
            <tr>
                <td class="py-2 text-sm uppercase tracking-widest font-medium text-left text-gray-600">Uploaded User
                </td>
                <td class="px-2">:</td>
                <td class="tracking-widest text-sm">{{$repository->student->name}}</td>
            </tr>
            <tr>
                <td class="py-2 text-sm uppercase tracking-widest font-medium text-left text-gray-600">Created Date
                </td>
                <td class="px-2">:</td>
                <td class="tracking-widest text-sm">{{$repository->created_at->format('d M y h:i')}}</td>
            </tr>
            <tr>
                <td class="py-2 text-sm uppercase tracking-widest font-medium text-left text-gray-600">Modified Date
                </td>
                <td class="px-2">:</td>
                <td class="tracking-widest text-sm">{{$repository->updated_at->format('d M y h:i')}}</td>
            </tr>
        </table>
    </div>
@endsection
