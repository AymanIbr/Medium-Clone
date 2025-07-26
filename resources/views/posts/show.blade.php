<x-app-layout>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>

                {{-- User Avatar --}}
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />
                    <div>
                        <div class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}"
                                class="hover:underline">{{ $post->user->name }}</a>
                            &middot;
                            <x-follow-button :user="$post->user" />
                        </div>
                        <div class="flex gap-2 text-sm text-gray-500">
                            {{ $post->readTime() }}
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>

                </div>

                {{-- Clap Section --}}
                <x-clap-button :count="$post->claps()->count()" :postId="$post->id" :clapped="$post->isClappedBy(auth()->user())" />

                {{--  --}}

                <div class="mt-4">
                    <img src="{{ $post->image_path }}" alt="{{ $post->title }}" class="w-full">

                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>

                <div class="mt-8">
                    <span class="px-4 py-2 bg-gray-200 rounded-2xl">
                        {{ $post->category->name }}
                    </span>
                </div>
                {{-- Clap Section --}}
                <x-clap-button :count="$post->claps()->count()" :postId="$post->id" :clapped="$post->isClappedBy(auth()->user())" />

            </div>
        </div>
    </div>


    @push('js')
        <script>
            $(document).on('click', '.follow-btn', function(e) {
                e.preventDefault();

                const button = $(this);
                const userId = button.data('user-id');

                $.ajax({
                    type: 'POST',
                    url: '/follow/' + userId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'followed') {
                            button.text('Unfollow');
                            button.removeClass('text-emerald-600').addClass('text-red-600');
                        } else if (response.status === 'unfollowed') {
                            button.text('Follow');
                            button.removeClass('text-red-600').addClass('text-emerald-600');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });

            $(document).on('click', '.clap-btn', function(e) {
                e.preventDefault();
                const button = $(this);
                const postId = button.data('post-id');

                $.ajax({
                    url: '/posts/' + postId + '/clap',
                    type: 'POST',
                    success: function(response) {
                        const buttons = $('.clap-btn[data-post-id="' + postId + '"]');

                        buttons.each(function() {
                            const btn = $(this);
                            btn.find('.clap-count').text(response.count);

                            if (response.status === 'clapped') {
                                btn.removeClass('text-gray-500').addClass('text-blue-600');
                            } else {
                                btn.removeClass('text-blue-600').addClass('text-gray-500');
                            }
                        });

                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        </script>
    @endpush


</x-app-layout>
