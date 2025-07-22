<div class="bg-dark text-white sidebar d-flex flex-column p-3">
    <a href="{{ url('/') }}" class="text-white text-decoration-none fs-4 fw-bold mb-3">Blog Site</a>
    <hr class="text-white">

    <ul class="nav nav-pills flex-column mb-auto">
        @auth
            @if(auth()->user()?->role === 'admin')
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                        Dashboard
                    </a>
                </li>

                {{-- Users --}}
                <li>
                    <a href="{{ route('admin.userdetails') }}"
                        class="nav-link text-white {{ request()->routeIs('admin.userdetails') ? 'active bg-primary' : '' }}">
                        Users List
                    </a>
                </li>

                {{-- Post Dropdown --}}
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#postMenu" role="button"
                        aria-expanded="{{ request()->routeIs('posts.*') || request()->routeIs('user.posts.create') ? 'true' : 'false' }}"
                        aria-controls="postMenu">
                        Post
                        <span class="bi bi-chevron-down"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('posts.*') || request()->routeIs('user.posts.create') ? 'show' : '' }}"
                        id="postMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                            <li>
                                <a href="{{ route('posts.index') }}"
                                    class="nav-link text-white {{ request()->routeIs('posts.index') ? 'active bg-primary' : '' }}">
                                    All Posts
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.posts.create') }}"
                                    class="nav-link text-white {{ request()->routeIs('user.posts.create') ? 'active bg-primary' : '' }}">
                                    Create Post
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Category Dropdown --}}
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#categoryMenu" role="button"
                        aria-expanded="{{ request()->routeIs('categories.*') ? 'true' : 'false' }}"
                        aria-controls="categoryMenu">
                        Category
                        <span class="bi bi-chevron-down"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('categories.*') ? 'show' : '' }}" id="categoryMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                            <li>
                                <a href="{{ route('categories.index') }}"
                                    class="nav-link text-white {{ request()->routeIs('categories.index') ? 'active bg-primary' : '' }}">
                                    All Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.create') }}"
                                    class="nav-link text-white {{ request()->routeIs('categories.create') ? 'active bg-primary' : '' }}">
                                    Create Category
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Tags Dropdown --}}
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#tagMenu" role="button" aria-expanded="{{ request()->routeIs('tags.*') ? 'true' : 'false' }}"
                        aria-controls="tagMenu">
                        Tags
                        <span class="bi bi-chevron-down"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('tags.*') ? 'show' : '' }}" id="tagMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                            <li>
                                <a href="{{ route('tags.index') }}"
                                    class="nav-link text-white {{ request()->routeIs('tags.index') ? 'active bg-primary' : '' }}">
                                    All Tags
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tags.create') }}"
                                    class="nav-link text-white {{ request()->routeIs('tags.create') ? 'active bg-primary' : '' }}">
                                    Create Tag
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="nav-link text-white {{ request()->routeIs('user.profile.index') ? 'active bg-primary' : '' }}">
                        Profile
                    </a>
                </li>
            @endif

            @auth
                @if(auth()->user()?->role !== 'admin')
                <!-- <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                            Dashboard
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#postMenu" role="button"
                            aria-expanded="{{ request()->routeIs('posts.*') || request()->routeIs('user.posts.create') ? 'true' : 'false' }}"
                            aria-controls="postMenu">
                            Post
                            <span class="bi bi-chevron-down"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('posts.*') || request()->routeIs('user.posts.create') ? 'show' : '' }}"
                            id="postMenu">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                                <li>
                                    <a href="{{ route('user.posts.index') }}"
                                        class="nav-link text-white {{ request()->routeIs('user.posts.index') ? 'active bg-primary' : '' }}">
                                        All Posts
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.posts.create') }}"
                                        class="nav-link text-white {{ request()->routeIs('user.posts.create') ? 'active bg-primary' : '' }}">
                                        Create Post
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="nav-link text-white {{ request()->routeIs('user.profile.index') ? 'active bg-primary' : '' }}">
                        Profile
                    </a>
                </li>
                @endif
            @endauth

            {{-- Logout --}}
            <li>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="btn btn-outline-light w-100 text-start" type="submit">Logout</button>
                </form>
            </li>
        @else
            {{-- Login --}}
            <li>
                <a href="{{ route('login') }}" class="btn btn-outline-light w-100 text-start mt-2">Login</a>
            </li>
        @endauth
    </ul>

</div>