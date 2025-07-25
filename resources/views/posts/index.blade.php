<x-app-layout>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">

                    {{-- <x-category-taps name="Zura" /> --}}
                    <x-category-taps>
                        No Categories Found.
                    </x-category-taps>

                </div>
            </div>


            <div class="text-gray-900 mt-8">
                @forelse ($posts as $post)
                    <x-post-item :post="$post" />
                @empty
                    <div class="text-center text-gray-500 mt-10">
                        <p class="text-lg">No posts available at the moment. Please check back later.</p>
                    </div>
                @endforelse
            </div>
            {{ $posts->onEachSide(1)->links() }}
            {{-- //php artisan vendor:publish --tag=laravel-pagination --}}
        </div>
    </div>
</x-app-layout>
