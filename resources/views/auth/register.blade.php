<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="/style/tailwind.js"></script>
</head>
<body>
<div class='flex flex-col items-center w-[450px] m-auto'>
    @include('common.header', ['current_user_dto' => null])
    <main class='w-full flex flex-col items-center'>
        <h2 class='text-2xl py-4'>Register</h2>
        <nav class='self-end'>
            <a href='/auth/login' class='text-blue-500 underline'>Login</a>
        </nav>
        <form action="/auth/register" method="post" class="w-full flex flex-col items-center gap-4">
            @csrf
            <div class="w-full">
                <label for="display_name" class="w-full text-left">User name</label>
                <input type="text" name="display_name" id="display_name"
                       class="w-full p-2 border border-gray-300 rounded-md" maxlength="30" required>
            </div>
            <div class="w-full">
                <label for="password" class="w-full text-left">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full p-2 border border-gray-300 rounded-md" minlength="8" maxlength="30" required>
                <p class="text-sm">
                    ※パスワードは8文字以上30文字以内で、大文字、小文字、数字、記号をそれぞれ1文字以上含めてください。記号は@$!%*?&_-が使用可能です。
                </p>
            </div>
            <div class="w-full">
                <label for="password_confirmation" class="w-full text-left">Password Conform</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full p-2 border border-gray-300 rounded-md" minlength="8" maxlength="30" required>
            </div>
            <div class="w-full">
                <label for="user_icon" class="w-full text-left">User icon</label>
                <input type="file" name="user_icon" id="user_icon" class="w-full p-2 border border-gray-300 rounded-md"
                       accept="image/jpeg, image/png, image/gif">
            </div>
            @foreach($errors->all() as $error)
                <p class='text-red-500'>{{$error}}</p>
            @endforeach
            <button type="submit" class="w-full p-2 bg-blue-500 text-white rounded-md">Register</button>
        </form>
    </main>
</div>
</body>
