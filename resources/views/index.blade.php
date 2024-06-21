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
        <form id="articleForm" class="flex flex-col gap-4 items-center w-fit" action="/articles" method="post"
              enctype="multipart/form-data">
            @csrf
            @foreach($errors->all() as $error)
                <p class='text-red-500'>{{$error}}</p>
            @endforeach
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="title">タイトル</label>
                <input class="w-[400px] p-1 border-2 border-gray-300" type="text" id="title" name="title"
                       maxlength="191" required>
            </div>
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="body">本文</label>
                <textarea class="w-[400px] p-2 border-2 border-gray-300 leading-[20px] h-[100px]" id="body" name="body"
                          required></textarea>
            </div>
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="thumbnail">サムネイル</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg, image/png, image/gif" class=""
                       required>
            </div>
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="images">画像</label>
                <input type="file" id="images" name="images[]" accept="image/jpeg, image/png, image/gif" multiple>
            </div>
            <div class="flex flex-col items-start gap-2 justify-between w-full">
                <label for="tags">タグ</label>
                <input class="w-[400px] p-1 border-2 border-gray-300" type="text" id="tags" name="tags" required>
                <p class="text-xs">※タグはカンマ区切りで入力してください</p>
            </div>
            <div class="flex gap-8">
                <button id="draft-submit-button" type="submit"
                        class="px-4 py-1 rounded-lg bg-gray-300 hover:bg-gray-400" data-action="/draft-articles">下書き
                </button>
                <button id="post-submit-button" type="submit" class="bg-cyan-400 hover:bg-cyan-500 rounded-lg px-4 py-1"
                        data-action="/articles">投稿
                </button>
            </div>
        </form>
        <section>
            <ul class="flex flex-col p-4 gap-4 w-[600px]">
                @foreach($articles as $article)
                    <li class="flex flex-col gap-1 items-center w-full">
                        @if($current_user_id && $current_user_id === $article->user_id)
                            <form class="self-end w-fit" method="post" action="/articles/{{$article->id}}/delete"
                                  onSubmit="return CheckDelete()">
                                @csrf
                                <button type="submit" class="text-red-500 underline">Delete</button>
                            </form>
                        @endif
                        <a class="w-full" href="/articles/{{$article->id}}">
                            <article class="bg-cyan-200 flex flex-col items-start px-4 py-2">
                                <h2 class="text-2xl font-bold">{{$article->title}}</h2>
                                <p class="text-lg line-clamp-3">{{$article->body}}</p>
                                <img class="self-center" src="{{$article->thumbnail_url}}"
                                     alt="{{$article->thumbnail_url}}" width="300" height="255">
                                <ul class="flex gap-2">
                                    @foreach($article->tags ?? [] as $tag)
                                        <li class="text-sm">#{{$tag}}</li>
                                    @endforeach
                                </ul>
                                <div class="flex items-center gap-2">
                                    <img class="user__icon" src="{{$article->user_icon_path ?? '#'}}"
                                         alt="{{$article->user_icon_path ?? '#'}}" width="50" height="50">
                                    <p class="text-sm">{{$article->user_display_name ?? 'Not Impl'}}</p>
                                    <p class="text-sm">{{$article->created_at}}</p>
                                </div>
                            </article>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </main>
</div>
</body>
</html>

