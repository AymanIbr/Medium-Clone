<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="flex">
                    <div class="flex-1">
                        <h1 class="text-5xl">{{ $user->name }}</h1>
                        <div class="mt-8 pr-6">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post" />
                            @empty
                                <p class="text-gray-500">No posts yet.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="w-[320px] border-l px-8">
                        <x-user-avatar :user="$user" size="w-24 h-24" />
                        <h3>{{ $user->name }}</h3>
                        <p id="followers-count" class="text-gray-500">
                            {{ $user->followers->count() }} Followers
                        </p>
                        <p>{{ $user->bio }}</p>
                        <div class="mt-4">
                            <x-follow-button :user="$user" />
                        </div>
                    </div>
                </div>

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
                    success: function(response) {
                        if (response.status === 'followed') {
                            button.text('Unfollow');
                            button.removeClass('text-emerald-600').addClass('text-red-600');
                        } else if (response.status === 'unfollowed') {
                            button.text('Follow');
                            button.removeClass('text-red-600').addClass('text-emerald-600');
                        }
                        $('#followers-count').text(response.followers_count + ' Followers');

                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
