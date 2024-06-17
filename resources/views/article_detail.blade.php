<!DOCTYPE html>
<html>
<head>
    <title>{{$article->title}}</title>
    <script src="/style/tailwind.js"></script>
    <script src="/scripts/article_submit.js" defer></script>
    <meta property="og:url" content="{{config('app.url')}}/articles/{{$article->article_id}}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{$article->title}}" />
    <meta property="og:description" content="{{substr($article->body, 0, 90)}}" />
    <meta property="og:site_name" content="Zenita" />
    <meta property="og:image" content="{{$article->thumbnail_image_url}}" />
</head>
<body>
<script>
    function CheckDelete() {
        return confirm('Are you sure you want to delete?');
    }
</script>
<div class='root'>
    @include('common.header', ['current_user_dto' => $current_user_dto])

    <div class='flex flex-col items-center w-[650px] m-auto'>
        @if($is_owner)
            <nav class="flex gap-2 self-end">
                <a href="/articles/{{$article->$article_id}}/edit" class="text-blue-500 underline">Edit</a>
                <form method="post" action="/articles/{{$article->article_id}}/delete" onSubmit="return CheckDelete()">
                    <button type="submit" class="text-red-500 underline">Delete</button>
                </form>
            </nav>
        @endif
        <main class=''>
            <article class='flex flex-col px-8 py-4 gap-8 bg-gray-200'>
                <h2 class='text-3xl font-bold'>{{$article->title}}</h2>
                <img class='object-contain' src='{{$article->thumbnail_image_url}}' alt='{{$article->title}})'
                     width='600' height='350'/>
                <p class=''>{{$article->body}}</p>
                <ul class=''>
                    @foreach($article->image_url_list as $image_url)
                        <li class=''>
                            <img src='{{$image_url}}' alt='' class='object-contain' width='300' height='225'/>
                        </li>
                    @endforeach
                </ul>
                <ul class="flex gap-2">
                    @foreach($article->tags as $tag)
                        <li class="text-sm">#{{$tag}}</li>
                    @endforeach
                </ul>
            </article>
        </main>
    </div>
</div>
</body>
</html>

