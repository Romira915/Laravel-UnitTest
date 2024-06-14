<header class='header'>
    <nav class="flex items-center justify-between bg-cyan-200 w-dvw px-4 mb-4">
        <h1 class="text-4xl py-4">Zenita</h1>
        @if($currentUserDTO === null)
            <div class="">
                <a class="text-lg py-1 px-3 bg-cyan-400 hover:bg-cyan-500 rounded-lg" href="/auth/login">Login
                </a>
            </div>
        @else
            <div class="flex items-center gap-1">
                <img id="logged-in-user-icon" class="" alt="user_icon"
                     title="{{$currentUserDTO->display_name}}" src="{{$currentUserDTO->icon_path}}" width="50" height="50">
                <form class="" action="/auth/logout" method="post">
                    <button type="submit" class="text-lg py-1 px-3 rounded-lg bg-gray-300 rounded hover:bg-gray-400">Logout</button>
                </form>
            </div>
        @endif
    </nav>
</header>
