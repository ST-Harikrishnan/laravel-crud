<div class="bg-dark text-white sidebar d-flex flex-column p-3">
    <a href="{{ url('/') }}" class="text-white text-decoration-none fs-4 fw-bold mb-3">Blog Site</a>
    <hr class="text-white">

    <ul class="nav nav-pills flex-column mb-auto">
        @auth
            @if(auth()->user()->is_admin)
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white {{ request()->routeIs('admin.users') ? 'active bg-primary' : '' }}">
                        Users List
                    </a>
                </li>
                 <li>
                    <a href="{{ route('posts.index') }}"
                        class="nav-link text-white {{ request()->routeIs('posts.*') ? 'active bg-primary' : '' }}">
                        Post Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}"
                        class="nav-link text-white {{ request()->routeIs('categories.*') ? 'active bg-primary' : '' }}">
                        Create Category
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags.index') }}"
                        class="nav-link text-white {{ request()->routeIs('tags.*') ? 'active bg-primary' : '' }}">
                        Create Tags
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ route('tags.index') }}"
                        class="nav-link text-white {{ request()->routeIs('tags.*') ? 'active bg-primary' : '' }}">
                        Create Tags
                    </a>
                </li> -->
                
            @endif
            
@endauth
          
            

            <li>
               <a href="{{ route('user.posts.create') }}"
                   class="nav-link text-white {{ request()->routeIs('user.posts.create') ? 'active bg-primary' : '' }}">
                    Create Post
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="btn btn-outline-light w-100 text-start" type="submit">Logout</button>
                </form>
            </li>

    </ul>
</div>
