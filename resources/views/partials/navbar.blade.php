{{-- s: Desktop Navbar --}}
<div class="lg:block lg:container flex justify-center px-4 sticky top-0 z-10 bg-white border-b">
    <nav class="flex items-center justify-between py-4 lg:w-10/12 mx-auto w-full">
        <a class="inline-flex gap-2 items-center cursor-pointer">
            <i class="fa-duotone fa-solid fa-book text-lg hidden lg:block"></i>
            <i id="mobile-navbar-toggle" class="fa-duotone fa-solid fa-bars text-lg lg:hidden"></i>
            <span class="text-xl font-semibold text-neutral">
                <span class="text-primary">E</span>
                Library
            </span>
        </a>
        <div class="lg:inline-flex items-center space-x-8 hidden">
            <a href="{{ route('dashboard') }}"
                class="nav-hover-link {{ request()->routeIs('dashboard') ? 'nav-active-link' : '' }}">Home</a>
            <a href="{{ route('book.index') }}"
                class="nav-hover-link {{ request()->routeIs('book.*') || request()->routeIs('loan.create') ? 'nav-active-link' : '' }}">Books</a>
            <a href="{{ route('repository.index') }}"
                class="nav-hover-link {{ request()->routeIs('repository.*') || request()->routeIs('loan.create') ? 'nav-active-link' : '' }}">Repositories</a>
            @auth('student')
                <a href="{{ route('feedback.index') }}"
                    class="nav-hover-link {{ request()->routeIs('feedback.index') ? 'nav-active-link' : '' }}">Feedback</a>
            @endauth
        </div>

        @guest('student')
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary text-white font-medium tracking-wide">Login</a>
        @endguest

        @auth('student')
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="User Image" src="{{ Vite::asset('resources/img/user.png') }}" />
                    </div>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-44 p-2 shadow">
                    <li><a href="{{ route('profile.index') }}">Profile</a></li>
                    <li><a href="{{ route('loan.index') }}">History</a></li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <li>
                            <button type="submit">Logout</button>
                        </li>
                    </form>
                </ul>
            </div>
        @endauth
    </nav>
</div>
{{-- e: Desktop Navbar --}}

{{-- s: Mobile Navbar --}}
<div id="mobile-navbar" class="hidden fixed z-50 bg-slate-50 overflow-hidden w-full shadow-md border-t-2">
    <div class="flex flex-col items-center justify-center space-y-4 w-full py-2">
        <a href="{{ route('dashboard') }}"
            class="text-sm p-2 {{ request()->routeIs('dashboard') ? 'nav-active-link' : '' }}">Home</a>
        <a href="{{ route('book.index') }}"
            class="text-sm p-2 {{ request()->routeIs('book.*') || request()->routeIs('loan.create') ? 'nav-active-link' : '' }}">Books</a>
        <a href="{{ route('repository.index') }}"
            class="nav-hover-link {{ request()->routeIs('repository.*') || request()->routeIs('loan.create') ? 'nav-active-link' : '' }}">Repositories</a>
        @auth('student')
            <a href="{{ route('feedback.index') }}"
                class="text-sm p-2 {{ request()->routeIs('feedback.index') ? 'nav-active-link' : '' }}">Feedback</a>
        @endauth
    </div>
</div>
{{-- e: Mobile Navbar --}}
