<!DOCTYPE html>
<html>
<head>
    <title>Zenita</title>
    <script src="/style/tailwind.js"></script>
    <script src="/scripts/article_submit.js" defer></script>
</head>
<body>
<script>
    function CheckDelete() {
        return confirm('Are you sure you want to delete?');
    }
</script>
<div class='root'>
    @include('common.header', ['current_user_id' => $current_user_id, 'current_user_display_name' => $current_user_display_name, 'current_user_icon_path' => $current_user_icon_path])
    <main class='flex flex-col gap-16 items-center'>
        <form class="flex flex-col gap-4 items-center w-fit"
              action="/articles/{{$article_edit_dto->article_id}}/edit"
              method="post" enctype="multipart/form-data">
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="title">タイトル</label>
                <input class="w-[400px] p-1" type="text" id="title" name="title" maxlength="100"
                       value="{{$article_edit_dto->title}}" required>
            </div>
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="body">本文</label>
                <textarea class="w-[400px] h-[' . $bodyHeight . 'px]' . ' p-2 leading-[20px]" id="body" name="body"
                          maxlength="8000" required>{{$article_edit_dto->body}}</textarea>
            </div>
            <button type="submit" class="bg-gray-300 px-4 py-1 rounded hover:bg-gray-400">Update</button>
        </form>
    </main>
</div>
</body>
</html>

