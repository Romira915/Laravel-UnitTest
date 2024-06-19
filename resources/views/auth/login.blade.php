<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="/style/tailwind.js"></script>
</head>
<body>
<div class='flex flex-col items-center w-[450px] m-auto'>
    @include('common.header', ['current_user_id' => null, 'current_user_display_name' => null, 'current_user_icon_path' => null])
    <main class='w-full flex flex-col items-center'>
        <h2 class='text-2xl py-4'>Login</h2>
        <nav class='self-end'>
            <a href='/auth/register' class='text-blue-500 underline'>Register</a>
        </nav>
        <form action="/auth/login" method="post" class="w-full flex flex-col items-center gap-4">
            @csrf
            <div class="w-full">
                <label for="display_name" class="w-full text-left">User name</label>
                <input type="text" name="display_name" id="display_name" class="w-full p-2 border border-gray-300 rounded-md" maxlength="100" required>
            </div>
            <div class="w-full">
                <label for="password" class="w-full text-left">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded-md" maxlength="30" required>
            </div>
            @foreach($errors->all() as $error)
                <p class='text-red-500'>{{$error}}</p>
            @endforeach
            <button type="submit" class="w-full p-2 bg-blue-500 text-white rounded-md">Login</button>
        </form>
    </main>
</div>
</body>
