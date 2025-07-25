<x-app-layout>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                {{-- <form  action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"> --}}
                <form id="create-form" enctype="multipart/form-data">
                    @csrf
                    {{-- Image --}}
                    <div>
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus />
                    </div>
                    <div id="image_error" class="invalid-feedback text-sm" style="color: red"></div>


                    {{-- Title --}}
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" autofocus />
                    </div>
                    <div id="title_error" class="invalid-feedback text-sm" style="color: red"></div>



                    {{-- Category --}}
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id"
                            class="border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id) >{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div id="category_error" class="invalid-feedback text-sm" style="color: red"></div>
                    </div>


                    {{-- content --}}
                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-input-textarea id="content" class="block mt-1 w-full" type="text" name="content"
                             autofocus> {{ old('content') }} </x-input-textarea>
                        {{-- <x-input-error :messages="$errors->get('content')" class="mt-2" /> --}}
                    </div>
                    <div id="content_error" class="invalid-feedback text-sm" style="color: red"></div>


                    <x-primary-button class="mt-4 submit"> SUBMIT </x-primary-button>
                </form>
            </div>
        </div>
    </div>


    @push('js')
        <script>
            $('#create-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData(this);
                $(".submit").prop("disabled", true);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('post.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(".submit").prop("disabled", false);
                        toastr.success(response.message || 'Post added successfully');
                        $('#create-form')[0].reset();
                        $('#create-form input, #create-form textarea').removeClass('border border-red-500');
                        $('.invalid-feedback').text('');
                    },
                    error: function(xhr) {
                        $(".submit").prop("disabled", false);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.image) {
                                $('#image').addClass('border border-red-500');
                                $('#image_error').text(errors.image[0]);
                            } else {
                                $('#image').removeClass('border border-red-500');
                                $('#image_error').text('');
                            }
                            if (errors.title) {
                                $('#title').addClass('border border-red-500');
                                $('#title_error').text(errors.title[0]);
                            } else {
                                $('#title').removeClass('border border-red-500');
                                $('#title_error').text('');
                            }

                            if (errors.category_id) {
                                $('#category_id').addClass('border border-red-500');
                                $('#category_error').text(errors.category_id[0]);
                            } else {
                                $('#category_id').removeClass('border border-red-500');
                                $('#category_error').text('');
                            }
                            if (errors.content) {
                                $('#content').addClass('border border-red-500');
                                $('#content_error').text(errors.content[0]);
                            } else {
                                $('#content').removeClass('border border-red-500');
                                $('#content_error').text('');
                            }
                        } else {
                            toastr.error("Something went wrong. Please try again.");
                            console.log(xhr.responseText);
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
