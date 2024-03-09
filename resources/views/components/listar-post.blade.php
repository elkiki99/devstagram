<div>
    @if($posts->count())
    @foreach ($posts as $post)
        <div class="flex items-center flex-col">
            <div>
                <div class="mb-5 flex">
                    <div>
                        <a href="{{ route("posts.index", $post->user) }}" class="font-bold">
                            {{ $post->user->username }}
                        </a>
                        <p class="text-sm text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div class="">
                    <a href="{{ route("posts.show", ["post" => $post, "user" => $post->user ]) }}">
                        <img src="{{asset("uploads") . "/" . $post->imagen}}" alt="Imagen del Post {{$post->titulo}}">
                    </a>
                </div>

                <p class="mt-5 font-medium ">{{ $post->descripcion }}</p>
                
                <div class="mt-5 mb-20">
                    @auth
                    <livewire:like-post :post="$post" />
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
    @else
        <p class="text-center text-gray-400">Todavía no hay posts, ¡sigue a personas para conectarte con ellas!</p>
    @endif
</div>